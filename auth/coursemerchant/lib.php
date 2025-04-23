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
 * @package    coursemerchant
 * @copyright  2013 Connected Shopping Ltd.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot .'/lib/accesslib.php');

class cm_sso_helper {

	static $cm_sso_debug = false;

	protected static function get_sso_data() {
		// check whether we have a user
		global $USER;

		$sso_parameters = array();
		$sso_parameters['sso_is_logged_in'] = 0;

		if (isloggedin() && (empty($USER->id) == false)) {
			if (isguestuser() == false) {
				$sso_parameters['sso_is_logged_in'] = 1;
				$sso_parameters['sso_user_id'] = $USER->id;
				$sso_parameters['sso_username'] = $USER->username;
				$sso_parameters['sso_firstname'] = $USER->firstname;
				$sso_parameters['sso_lastname'] = $USER->lastname;
			}
		}
		$sso_parameters['sso_time'] = time();
		$sso_signature = cm_sso_helper::generate_signature($sso_parameters);
		$sso_parameters['sso_signature'] = $sso_signature;
		return $sso_parameters;
	}

	public static function check_logged_in_json() {
		$request_parameters = array();
		$request_parameters['sso_time'] = required_param('sso_time', PARAM_INT);
		$request_signature = required_param('sso_signature', PARAM_TEXT);

		if (cm_sso_helper::validate_sso_data($request_parameters, $request_signature)) {
			$sso_parameters = cm_sso_helper::get_sso_data();

			echo 'function cm_sso_moodle_login_info_' .$request_signature .'() {';
			echo 'return ' .json_encode($sso_parameters) .';';
			echo '}';
		}
	}

	public static function check_logged_in_redirect() {
		global $CFG;
		$request_parameters = array();
		$request_parameters['sso_return_url'] = required_param('sso_return_url', PARAM_URL);
		$request_parameters['sso_time'] = required_param('sso_time', PARAM_INT);
		$request_signature = required_param('sso_signature', PARAM_TEXT);

		if (cm_sso_helper::validate_sso_data($request_parameters, $request_signature)) {
			$sso_parameters = cm_sso_helper::get_sso_data();

			$query_string = http_build_query($sso_parameters, null, '&');
			$logged_in_redirect_url = $request_parameters['sso_return_url'] .'&' .$query_string;
			redirect($logged_in_redirect_url);

		}
		// Failed, return to CM login form.
		$login_url = $CFG->auth_coursemerchant_cm_base_url .'/account?action=login_form';
		redirect($login_url);
	}

	public static function log_in_redirect() {
		global $CFG;
		$request_parameters = array();
		$request_parameters['sso_user_id'] = required_param('sso_user_id', PARAM_INT);
		$request_parameters['sso_redirect_url'] = required_param('sso_redirect_url', PARAM_URL);
		$request_parameters['sso_time'] = required_param('sso_time', PARAM_INT);
		$request_signature = required_param('sso_signature', PARAM_TEXT);

		if (cm_sso_helper::validate_sso_data($request_parameters, $request_signature)) {
			// log in
			$user_id = $request_parameters['sso_user_id'];
			$user = get_complete_user_data('id', $user_id, $CFG->mnet_localhost_id);
			if ($user) {
				complete_user_login($user);

				$log_in_redirect_url = $request_parameters['sso_redirect_url'];
				if (trim($log_in_redirect_url) == '') {
					die('Redirect URL not provided.');
				}
				redirect($log_in_redirect_url);
			} else {
				die('User not found.');
			}
		}
		// Failed, die()
		die('SSO Request not valid.');
	}

	public static function log_out_redirect() {
		global $CFG;
		$request_parameters = array();
		$request_parameters['sso_redirect_url'] = required_param('sso_redirect_url', PARAM_URL);
		$request_parameters['sso_time'] = required_param('sso_time', PARAM_INT);
		$request_signature = required_param('sso_signature', PARAM_TEXT);

		if (cm_sso_helper::validate_sso_data($request_parameters, $request_signature)) {
			// log out unconditionally
			$log_out_redirect_url = $request_parameters['sso_redirect_url'];
			if (trim($log_out_redirect_url) == '') {
				die('Redirect URL not provided.');
			}
			require_logout();
			redirect($log_out_redirect_url);
		}
		// Failed, die()
		die('SSO Request not valid.');
	}

	public static function logout_notify() {
		global $CFG, $USER;

		if (!is_enabled_auth('coursemerchant')) {
			return;
		}

		if (isguestuser()) {
			return;
		}

		if (empty($USER->id) == false) {
			if ($CFG->auth_coursemerchant_cm_base_url) {
				// The base URL setting on may contain multiple Course Merchant URLs separated commas
				// Split and loop through notifying each Course Merchant of the logout
				$cm_base_urls = explode(',', $CFG->auth_coursemerchant_cm_base_url);
				foreach ($cm_base_urls as $cm_base_url) {
					$sso_parameters = array(
						'sso_user_id' => $USER->id,
						'sso_time' => time(),
					);
					$sso_signature = cm_sso_helper::generate_signature($sso_parameters);
					$sso_parameters['sso_signature'] = $sso_signature;
					$query_string = http_build_query($sso_parameters, null, '&');
					$logout_notify_url = trim($cm_base_url) .'/account?action=logout_sso_notify&' .$query_string;
					cm_sso_helper::call_url_async($logout_notify_url);
				}
			}
		}
	}

	protected static function validate_sso_data($sso_parameters, $sso_signature) {
		$our_signature = cm_sso_helper::generate_signature($sso_parameters);
		if ($our_signature != $sso_signature) {
			cm_sso_helper::cm_add_to_log(SITEID, 'coursemerchant', 'sso', '', "SSO signature hmac validation failed: sso_hmac: $sso_signature, our_hmac: $our_signature", 0, 0);
			return false;
		}
		$sso_time = $sso_parameters['sso_time'];
		$valid_seconds = 30;
		$our_time = time();
		if (abs($our_time - $sso_time) > $valid_seconds) {
			cm_sso_helper::cm_add_to_log(SITEID, 'coursemerchant', 'sso', '', "SSO signature validation failed time difference too large", 0, 0);
			return false;
		}
		return true;
	}

	public static function generate_signature($sso_parameters) {
		global $CFG;
		if (is_array($sso_parameters) == false) {
			throw new Exception('sso_parameters array required');
		}
		$hmac_key = $CFG->auth_coursemerchant_sso_key;
		$hmac_data = implode('~', $sso_parameters);
		$request_signature = hash_hmac("sha256", $hmac_data, $hmac_key);
		return $request_signature;
	}

	public static function call_url_async($url) {
		if (empty($url)) {
			throw new Exception('url should not be empty');
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		if ($result === false) {
			cm_sso_helper::cm_add_to_log(SITEID, 'coursemerchant', 'sso callback', '', "SSO: could not open connection: " .curl_errno($ch) .", " .curl_error($ch), 0, 0);
		}
		curl_close($ch);
		return;
	}

	/**
	* Convert legacy log calls to simple event.
	*
	* @param    int     $courseid  The course id
	* @param    string  $module  The module name  e.g. forum, journal, resource, course, user etc
	* @param    string  $action  'view', 'update', 'add' or 'delete', possibly followed by another word to clarify.
	* @param    string  $url     The file and parameters used to see the results of the action
	* @param    string  $info    Additional description information
	* @param    int     $cm      The course_module->id if there is one
	* @param    int|stdClass $user If log regards $user other than $USER
	* @return void
	*/
	public static function cm_add_to_log($courseid, $module, $action, $url='', $info='', $cm=0, $user=0) {
		$params = array();
		$params['other']['method'] = $action;
		$params['other']['reason'] = $info;
		$event = \auth_coursemerchant\event\auth_error::create($params);
		$event->trigger();
	}

}
