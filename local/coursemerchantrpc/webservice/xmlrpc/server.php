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
 * XML-RPC web service entry point. The authentication is done via tokens.
 *
 * @package   cm_webservice
 * @copyright 2009 Moodle Pty Ltd (http://moodle.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// disable moodle specific debug messages and any errors in output
define('NO_DEBUG_DISPLAY', true);
define('NO_MOODLE_COOKIES', true);

require('../../../../config.php'); // Moodle config

// error_log(__FILE__);
// error_log(print_r($_SERVER, true));
// error_log(print_r($_POST, true));
// if (empty($HTTP_RAW_POST_DATA)) {
//     $HTTP_RAW_POST_DATA = file_get_contents('php://input');
// }
// error_log(print_r($HTTP_RAW_POST_DATA, true));

require_once("$CFG->dirroot/local/coursemerchantrpc/webservice/lib.php");

if ($CFG->local_cm_enrol_rpc_enabled == false) {
	throw new cm_webservice_access_exception('Course Merchant RPC is not enabled!');
}

$cm_service_info = cm_get_service_info();
$webservice_auth = new cm_webservice_auth($cm_service_info);

$server = new cm_webservice_xmlrpc_server($webservice_auth);
$server->run();
die;

class cm_webservice_auth {

	protected $token = null;
	protected $service_info = null;

	public function __construct($service_info) {
		if (!is_object($service_info)) {
			throw new cm_webservice_access_exception('Service info must be provided!');
		}
		$this->service_info = $service_info;
		$this->parse_request();
	}
	
	/**
	* Authenticate user using username+password or token.
	* This function sets up $USER global.
	* It is safe to use has_capability() after this.
	* This method also verifies user is allowed to use this
	* server.
	* @return void
	*/
	public function authenticate() {
		global $CFG, $DB;

		if (!NO_MOODLE_COOKIES) {
			throw new cm_webservice_access_exception('Cookies must be disabled in WS servers!');
		}

		if (!in_array($this->token, $this->service_info->tokens)) {
			// log failed login attempts
			$params = array();
			$params['other']['method'] = 'Login token';
			$params['other']['reason'] = "Token not valid: ".$this->token. " - ".getremoteaddr();
			$event = \local_coursemerchantrpc\event\webservice_error::create($params);
			$event->trigger();

			throw new cm_webservice_access_exception('Token not valid');
		}

		$remoteaddr = getremoteaddr();
		if ($this->service_info->iprestriction and !address_in_subnet($remoteaddr, $this->service_info->iprestriction)) {
			$params = array();
			$params['other']['method'] = 'Login token';
			$params['other']['reason'] = "IP not valid: ".getremoteaddr();
			$event = \local_coursemerchantrpc\event\webservice_error::create($params);
			$event->trigger();
			throw new cm_webservice_access_exception('Access to external function not allowed from your IP address.');
		}

		if (!$user = $DB->get_record('user', array('username'=>$this->service_info->username, 'deleted'=>0), '*', IGNORE_MISSING)) {
			$params = array();
			$params['other']['method'] = 'Login token';
			$params['other']['reason'] = "Service Username not valid: ".$this->service_info->username;
			$event = \local_coursemerchantrpc\event\webservice_error::create($params);
			$event->trigger();
			debugging("Error: local/coursemerchantrpc Service username not found: " .$this->service_info->username, DEBUG_DEVELOPER);
			throw new cm_webservice_access_exception('Service username not found.');
		}

		// now fake user login, the session is completely empty too
		\core\session\manager::set_user($user); // Change to call for Moodle 3

		return $user->id;
	}

	/**
	* This method parses the $_REQUEST superglobal and looks for
	* the following information:
	*  1/ user authentication token
	*
	* @return void
	*/
	protected function parse_request() {
		// error_log(__FILE__ .':'.__METHOD__.':'.__LINE__);
		if (isset($_REQUEST['wstoken'])) {
			$this->token = trim($_REQUEST['wstoken']);
		}
		if (empty($this->token)) {
			$params = array();
			$params['other']['method'] = 'Login token';
			$params['other']['reason'] = "Token required: - ".getremoteaddr();
			$event = \local_coursemerchantrpc\event\webservice_error::create($params);
			$event->trigger();
			throw new cm_webservice_access_exception('Token not valid');
		}
	}

}