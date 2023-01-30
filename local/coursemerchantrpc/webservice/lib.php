<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Web services utility functions and classes
 *
 * @package   cm_webservice
 * @copyright 2009 Moodle Pty Ltd (http://moodle.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author Course Merchant  Development Team <support@coursemerchant.com>
 */

require_once($CFG->libdir.'/externallib.php');
require_once(dirname(__FILE__) .'/../lib/coursemerchant_rpc_v4.php');

function cm_get_service_info() {
	global $CFG;

	$username = 'admin';
	if (isset($CFG->local_cm_enrol_rpc_enabled) && empty($CFG->local_cm_enrol_rpc_enabled) == false) {
		$username = $CFG->local_cm_enrol_rpc_username;
	}

	$tokens = array();
	if (isset($CFG->local_cm_enrol_rpc_token) && empty($CFG->local_cm_enrol_rpc_token) == false) {
		$tokens[] = $CFG->local_cm_enrol_rpc_token;
	} else {
		throw new cm_webservice_access_exception('Course Merchant RPC token is not configured!');
	}

	$cm_service_info = new stdClass();
	$cm_service_info->username = $username;
	$cm_service_info->tokens = $tokens;
	$cm_service_info->iprestriction = null; // e.g. '127.0.0.1/24'
	return $cm_service_info;
}

/**
 * Exception indicating access control problem in web service call
 */
class cm_webservice_access_exception extends moodle_exception {
	/**
	* Constructor
	*/
	function __construct($debuginfo) {
		parent::__construct('accessexception', 'cm_webservice', '', null, $debuginfo);
	}
}



/**
 * Classes to implement remote XMLRPC API
 *
 * @copyright  2010-16 Connected Shopping
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// class cm_webservice_xmlrpc_server extends webservice_xmlrpc_server {
class cm_webservice_xmlrpc_server {

	/** @var string $response The XML-RPC response string. */
	protected $response;

	protected $cm_webservice_auth;
	protected $cm_class;
	protected $cm_method;
	protected $cm_params;
	protected $user_id;

	public function __construct(cm_webservice_auth $cm_webservice_info) {
		$this->cm_webservice_auth = $cm_webservice_info;
	}

	/**
	 * This method parses the request input, it needs to get:
	 *  1/ user authentication - username+password or token
	 *  2/ function name
	 *  3/ function parameters
	 *  Ensure that requested class matches coursemerchant_rpc_v4, and that coursemerchant_rpc_v4 can be found
	 *  Ensure that function name exists in specified class
	 */
	protected function parse_request() {
		// Get the XML-RPC request data.
		$rawpostdata = file_get_contents("php://input");
		$fullmethodname = null;

		// Decode the request to get the decoded parameters and the name of the method to be called.
		$decodedparams = xmlrpc_decode_request($rawpostdata, $fullmethodname, 'UTF-8');

		$class_method = explode(".", $fullmethodname);
		if (count($class_method) != 2) {
			throw new cm_webservice_access_exception('Unknown parameter expansion encountered: ' . print_r($fullmethodname, true));
		}

		if ($class_method[0] != 'coursemerchant_rpc_v4') {
			throw new cm_webservice_access_exception('Unsupported class request sent: ' . print_r($fullmethodname, true));
		}

		$available_methods = get_class_methods($class_method[0]);
		if (in_array($class_method[1], $available_methods) == false) {
			throw new cm_webservice_access_exception('Unsupported method request sent: ' . print_r($fullmethodname, true));
		}

		// Only if we have passed all the checks, get here
		$this->cm_class = $class_method[0];
		$this->cm_method = $class_method[1];
		$this->cm_params = $decodedparams;
	}

	/*  Overide normal authentication as the normal method assumes that the tokens are stored in particular Moodle locations */
	public function authenticate_user() {
		// This throws an exception if the token sent does not match
		$this->user_id = $this->cm_webservice_auth->authenticate();
	}

	/**
	 * Execute previously loaded function using parameters parsed from the request data.
	 */
	protected function execute() {
		$cm_worker_instance = new $this->cm_class();
		$this->returns = call_user_func_array(array($cm_worker_instance, $this->cm_method), array_values($this->cm_params));
	}

	/**
	 * Prepares the response.
	 */
	protected function prepare_response() {
		try {
			$encodingoptions = array(
				"encoding" => "utf-8",
				"verbosity" => "no_white_space"
			);
			$this->response = xmlrpc_encode_request(null, $this->returns, $encodingoptions);
		} catch (invalid_response_exception $ex) {
			$this->response = $this->generate_error($ex);
		}
	}

	/**
	 * Sends the headers for the XML-RPC response.
	 */
	protected function send_headers() {
                $lengthresponse = $this->response === NULL ? 0 : strlen($this->response);

		// Standard headers.
		header('HTTP/1.1 200 OK');
		header('Connection: close');
		header('Content-Length: ' . $lengthresponse);
		header('Content-Type: text/xml; charset=utf-8');
		header('Date: ' . gmdate('D, d M Y H:i:s', 0) . ' GMT');
		header('Server: Moodle XML-RPC Server/1.0');
		// Other headers.
		header('Cache-Control: private, must-revalidate, pre-check=0, post-check=0, max-age=0');
		header('Expires: '. gmdate('D, d M Y H:i:s', 0) .' GMT');
		header('Pragma: no-cache');
		header('Accept-Ranges: none');
		// Allow cross-origin requests only for Web Services.
		// This allow to receive requests done by Web Workers or webapps in different domains.
		header('Access-Control-Allow-Origin: *');
	}

	/**
	 * Send the result of function call to the WS client.
	 */
	protected function send_response() {
		$this->prepare_response();
		$this->send_headers();
		echo $this->response;
	}

	/**
	 * Send the error information to the WS client.
	 *
	 * @param Exception $ex
	 */
	protected function send_error($ex = null) {
		$this->response = $this->generate_error($ex);
		$this->send_headers();
		echo $this->response;
	}

	/**
	 * Generate the XML-RPC fault response.
	 *
	 * @param Exception $ex The exception.
	 * @return string The XML-RPC fault response xml containing the faultCode and faultString.
	 */
	protected function generate_error(Exception $ex) {
		$error = $ex->getMessage();

		$faultcode = $ex->getCode();

		$fault = array(
			'faultCode' => (int) $faultcode,
			'faultString' => $error
		);

		$encodingoptions = array(
			"encoding" => "utf-8",
			"verbosity" => "no_white_space"
		);

		return xmlrpc_encode_request(null, $fault, $encodingoptions);
	}

	/**
	 * Specialised exception handler, we can not use the standard one because
	 * it can not just print html to output.
	 *
	 * @param exception $ex
	 * $uses exit
	 */
	public function exception_handler($ex) {
		// detect active db transactions, rollback and log as error
		abort_all_db_transactions();

		// now let the plugin send the exception to client
		$this->send_error($ex);

		// not much else we can do now, add some logging later
		exit(1);
	}

	/**
	 * Process request from client.
	 *
	 * @uses die
	 */
	public function run() {
		// we will probably need a lot of memory in some functions
		raise_memory_limit(MEMORY_EXTRA);

		// set some longer timeout, this script is not sending any output,
		// this means we need to manually extend the timeout operations
		// that need longer time to finish
		external_api::set_timeout();

		// set up exception handler first, we want to sent them back in correct format that
		// the other system understands
		// we do not need to call the original default handler because this ws handler does everything
		set_exception_handler(array($this, 'exception_handler'));

		// init all properties from the request data, class and method exists
		$this->parse_request();

		// authenticate user, this has to be done after the request parsing
		// this also sets up $USER and $SESSION
		$this->authenticate_user();

		// Log the web service request.
		$params = array(
			'other' => array(
			'function' => $this->cm_class . "." . $this->cm_method,
			)
		);
		$event = \core\event\webservice_function_called::create($params);
		$event->set_legacy_logdata(array(SITEID, 'webservice', $this->cm_class . "." . $this->cm_method, '', getremoteaddr(), 0, $this->user_id));
		$event->trigger();

		// finally, execute the function - any errors are catched by the default exception handler
		$this->execute();

		// send the results back in correct format
		$this->send_response();

		die;
	}

}
