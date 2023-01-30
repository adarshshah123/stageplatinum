<?php

require_once($CFG->dirroot.'/user/profile/lib.php');

class CM_RPC_EXCEPTION extends Exception {}

class cm_rpc_v4 extends cm_rpc_v4_base {

	function __construct() {
		parent::__construct();
		// Add addition core fields for Kineo
		// $this->allowed_user_core_fields[] = 'additional_field';
	}
}

class cm_rpc_v4_base {

	var $allowed_user_lookup_columns  = array(
		'id',
		'username',
		'idnumber',
		'email',
	);

	var $required_user_core_fields = array(
		'username',
		'email',
		'firstname',
		'lastname',
	);

	var $allowed_user_core_fields = array(
		'username',
		'idnumber',
		'email',
		'firstname',
		'lastname',
		'institution',
		'department',
		'address',
		'city',
		'country',
		'phone1',
		'phone2',
		'icq',
		'skype',
		'yahoo',
		'aim',
		'msn',
		'description',
		'confirmed',
		'policyagreed',
		'auth',
		'timezone'
	);

	// Only allow updating ancillary user core fields
	var $allowed_user_core_update_fields = array(
		'institution',
		'department',
		'address',
		'city',
		'country',
		'phone1',
		'phone2',
		'icq',
		'skype',
		'yahoo',
		'aim',
		'msn',
		'description',
		'timezone',
	);

	var $missing_core_fields = array();
	var $missing_core_fields_error = false;

	var $unknown_core_fields = array();
	var $unknown_core_fields_warning = false;

	var $missing_profile_fields = array();
	var $missing_profile_fields_warning = false;

	const USER_NOT_EXISTS = 10000;
	const USER_NAME_EXISTS = 10001;
	const USER_NAME_ALPHANUM = 10002;
	const COLUMN_NOT_ALLOWED = 10003;
	const USER_CORE_INVALID = 10004;
	const USER_PROFILE_FIELDS_INVALID = 10005;
	const FAILED_CREATE = 10006;
	const PASSWORD_INVALID = 10020;
	const PASSWORD_INCORRECT = 10021;
	const EMAIL_NOT_ALLOWED = 10030;
	const EMAIL_INVALID = 10031;
	const EMAIL_EXISTS = 10032;

	const COURSE_NOT_FOUND = 10100;
	const COURSE_REQUIRED = 10101;
	const COURSE_META_NOT_ALLOWED = 10103;
	const ROLE_NOT_FOUND = 10104;

	const ROLE_NOT_EXTENDED = 10110;

	const ADD_LICENSES_FAILED = 10310;

	const NOT_IMPLEMENTED_ERROR = 10200;
	const PARAMETER_ERROR = 10210;

	const NO_ENROLMENT_MODULE = 10400;

	function __construct() {
		global $CFG, $DB;
		$this->CFG = $CFG;
		$this->DB = $DB;
	}

	function cm_throw($code, $message = '') {
		error_log('CM_RPC_V3 Error: Code: ' .$code .' : Message : ' .$message);
		throw new CM_RPC_EXCEPTION($message, $code);
	}

	function _user_column_allowed($column_name) {
		return in_array($column_name, $this->allowed_user_lookup_columns);
	}

	function users_get_by_column_values($column_name, $field_values, $return_fields) {
		// error_reporting(E_ALL | E_NOTICE);
		if ($this->_user_column_allowed($column_name) === false) {
			$this->cm_throw(self::COLUMN_NOT_ALLOWED, 'Column name not allowed: ' .$column_name);
		}
		if (is_array($return_fields) && count($return_fields) > 0) {
			$select = implode(',', $return_fields);
		} else {
			$select = "id,email";
		}
		// error_log('Column name: ' .print_r($column_name, true));
		// error_log('Field values: ' .print_r($field_values, true));
		// error_log('Return Fields: ' .print_r($return_fields, true));
		// error_log('$select: ' .print_r($select, true));
		// function get_records_list($table, $field='', $values='', $sort='', $fields='*', $limitfrom='', $limitnum='') {
		// public function get_records_list($table, $field, array $values, $sort='', $fields='*', $limitfrom=0, $limitnum=0) {
		if ($users = $this->DB->get_records_list('user', $column_name, $field_values, '', $select)) {
			// error_log('Users: ' .print_r($users, true));
			return $users;
		}
		// error_log('Users: ' .print_r($users, true));
		return false;
	}

	function user_get_by_column($column_name, $field_value) {
		if ($this->_user_column_allowed($column_name) === false) {
			$this->cm_throw(self::COLUMN_NOT_ALLOWED, 'Column name not allowed: ' .$column_name);
		}
		if ($user = $this->DB->get_record('user', array($column_name => $field_value, 'mnethostid' => $this->CFG->mnet_localhost_id))) {
			return $user;
		}
		return false;
	}

	function user_get_complete($column_name, $field_value) {
		if ($user = $this->user_get_by_column($column_name, $field_value)) {
			$return = new stdClass();
			$return->user = $user;
			$return->profile_fields = $this->get_user_info_fields($user->id);
			return $return;
		}
		return false;
	}

	function user_get_by_username_cas_sso($username) {
		if ($this->user_check_exists($username)) {
			return $this->user_get_complete('username', $username);
		}
		return false;
	}

	function user_check_exists($username) {
		// if (record_exists('user', 'username', $username, 'mnethostid', $this->CFG->mnet_localhost_id)) { mdl 1.9
		try {
			$result = $this->DB->record_exists('user', array('username'=>$username, 'mnethostid'=>$this->CFG->mnet_localhost_id));
		} catch (Exception $e) {
			$this->cm_throw(self::USER_NOT_EXISTS, print_r($e, true));
		}

		if ($result) {
			return true;
		}
		return false;
	}

	function user_check_credentials($username, $password) {
		$user = authenticate_user_login(addslashes($username), $password);
		if (!$user) {
			return false;
		}
		$user_complete = $this->user_get_complete('id', $user->id);
		if ($user_complete) {
			return $user_complete;
		}
		return false;
	}

	function user_create($user_core_fields, $user_profile_fields, $password, $check_password_policy) {
		global $CFG;

		// error_log('$user_core_fields=' .print_r($user_core_fields, true));
		// error_log('$user_profile_fields=' .print_r($user_profile_fields, true));
		// $data = (object)$data;

		if (($user = $this->_user_validate_core($user_core_fields, $password, $check_password_policy)) === false) {
			$this->cm_throw(self::USER_CORE_INVALID, 'Unknown user core fields validation error.');
		}

		if ($this->_user_validate_profile_fields($user_profile_fields) === false) {
			$this->cm_throw(self::USER_PROFILE_FIELDS_INVALID, 'Unknown profile field validation error.');
		}

		// error_log(__LINE__ .' ' .print_r($user, true));

		$transaction = $this->DB->start_delegated_transaction();

		$user = $this->_user_core_add_defaults($user);

		$user->password = hash_internal_user_password($password);

		// error_log(__LINE__ .' ' .print_r($user, true));
		try {
			$user->id = $this->DB->insert_record('user', $user);
		} catch (Exception $e) {
			$this->cm_throw(self::FAILED_CREATE, print_r($e, true));
		}
		if (!$user->id) {
			$this->cm_throw(self::FAILED_CREATE, 'Failed to create user.');
		}
		// error_log(__LINE__ .' ' .print_r($user, true));

		/// Save any custom profile field information
		try {
			$this->_user_save_profile_fields($user->id, $user_profile_fields);
		} catch (Exception $e) {
			$this->cm_throw(self::FAILED_CREATE, print_r($e, true));
		}

		$transaction->allow_commit();

		// Trigger event - moodle 2.6
		// $user_context = context_user::instance($user->id);
		// $event = \core\event\user_created::create(
		// 	array(
		// 		'objectid' => $user->id,
		// 		'relateduserid' => $user->id,
		// 		'context' => $user_context
		// 		)
		// 	);
		// $event->trigger();

		// Trigger event - moodle 2.7+
		\core\event\user_created::create_from_userid($user->id)->trigger();

		// Create a return object to signal success and any warnings
		$return = new stdClass();
		$return->result = $user->id;
		if ($this->unknown_core_fields_warning) {
			$return->unknown_core_fields = $this->unknown_core_fields;
		}
		if ($this->missing_profile_fields_warning) {
			$return->missing_profile_fields = $this->missing_profile_fields;
		}
		return $return;
	}

	function _user_validate_core($user_core_fields, $password, $check_password_policy) {

		// Check that our required field are set, throw and error if not.
		foreach ($this->required_user_core_fields as $required_fieldname) {
			if (empty($user_core_fields[$required_fieldname])) {
				$this->missing_core_fields[] = $required_fieldname;
				$this->missing_core_fields_error = true;
			}
		}
		if ($this->missing_core_fields_error) {
			$this->cm_throw(self::USER_CORE_INVALID, 'Required user_core_fields missing: ' .implode(', ', $this->missing_core_fields));
		}

		// Copy only allowed fields into a new user object and save a list of not allowed fields.
		$user = new stdClass();
		foreach ($user_core_fields as $fieldname => $fieldvalue) {
			if (in_array($fieldname, $this->allowed_user_core_fields)) {
				$user->{$fieldname} = $fieldvalue;
			} else {
				$this->unknown_core_fields[] = $fieldname;
				$this->unknown_core_fields_warning = true;
			}
		}

		if (empty($password)) {
			$this->cm_throw(self::PASSWORD_INVALID, 'Password must not be empty.');
		}

		if ($this->user_check_exists($user->username)) {
			$this->cm_throw(self::USER_NAME_EXISTS, 'Username already Exists.');
		}

		//check allowed characters
		if ($user->username !== strtolower($user->username)) {
			$this->cm_throw(self::USER_NAME_ALPHANUM, 'Username should be lowercase.');
		} else {
			if ($user->username !== clean_param($user->username, PARAM_USERNAME)) {
				$this->cm_throw(self::USER_NAME_ALPHANUM, 'Username should be alphanumerical.');
			}
		}

		if (!validate_email($user->email)) {
			$this->cm_throw(self::EMAIL_INVALID, 'Email address is invalid.');
		}
		if ($this->DB->record_exists('user', array('email' => $user->email))) {
			$this->cm_throw(self::EMAIL_EXISTS, 'Email address is already in use.');
		}
		if ($err = email_is_not_allowed($user->email)) {
			$this->cm_throw(self::EMAIL_NOT_ALLOWED, 'Email address is not allowed.');
		}

		$errmsg = '';
		if ($check_password_policy && !check_password_policy($password, $errmsg)) {
			$this->cm_throw(self::PASSWORD_INVALID, $errmsg);
		}

		return $user;
	}

	function _user_core_add_defaults($user_core_fields) {
		if (empty($user_core_fields->confirmed)) $user_core_fields->confirmed   = '0';
		if (empty($user_core_fields->country)) $user_core_fields->country = '';
		if (empty($user_core_fields->city)) $user_core_fields->city = '';
		$user_core_fields->lang = current_language();
		// Additional required core time fields
		$user_core_fields->timecreated = $user_core_fields->timemodified = $user_core_fields->firstaccess = time();
		$user_core_fields->mnethostid = $this->CFG->mnet_localhost_id;
		$user_core_fields->secret = random_string(15);
		$user_core_fields->auth = 'manual';
		return $user_core_fields;
	}

	function user_update($user_id, $user_core_fields, $user_profile_fields) {
		global $CFG;

		// error_log('$user_core_fields=' .print_r($user_core_fields, true));
		// error_log('$user_profile_fields=' .print_r($user_profile_fields, true));
		// $data = (object)$data;

		if (($user = $this->user_get_by_column('id', $user_id)) === false) {
			$this->cm_throw(self::USER_NOT_EXISTS, 'User does not exist: ' .$user_id);
		}

		if (($user = $this->_user_validate_core_update($user, $user_core_fields)) === false) {
			$this->cm_throw(self::USER_CORE_INVALID, 'Unknown user core fields validation error.');
		}

		if ($this->_user_validate_profile_fields($user_profile_fields) === false) {
			$this->cm_throw(self::USER_PROFILE_FIELDS_INVALID, 'Unknown profile field validation error.');
		}

		// error_log(__LINE__ .' ' .print_r($user, true));

		$transaction = $this->DB->start_delegated_transaction();

		// error_log(__LINE__ .' ' .print_r($user, true));
		try {
			if ($this->DB->update_record('user', $user) == false) {
				$this->cm_throw(self::FAILED_CREATE, 'Failed to create user.');
			}
		} catch (Exception $e) {
			error_log('Exception:' .print_r($e, true));
			$transaction->rollback($e);
			$this->cm_throw(self::FAILED_CREATE, 'Failed to create user - db exception: ' .$e->getTraceAsString());
		}
		// error_log(__LINE__ .' ' .print_r($user, true));

		/// Save any custom profile field information
		$this->_user_save_profile_fields($user->id, $user_profile_fields);

		$transaction->allow_commit();

		// Create a return object to signal success and any warnings
		$return = new stdClass();
		$return->result = $user->id;
		if ($this->unknown_core_fields_warning) {
			$return->unknown_core_fields = $this->unknown_core_fields;
		}
		if ($this->missing_profile_fields_warning) {
			$return->missing_profile_fields = $this->missing_profile_fields;
		}
		return $return;
	}

	function user_force_password_change($user_id) {
		return set_user_preference('auth_forcepasswordchange', 1, $user_id); // set_user_preference is defined in lib\moodlelib.php Always returns true or exception
	}

	function _user_validate_core_update($user, $user_core_fields) {

		// Copy only allowed fields into a new user object and save a list of not allowed fields.
		foreach ($user_core_fields as $fieldname => $fieldvalue) {
			if (in_array($fieldname, $this->allowed_user_core_update_fields)) {
				$user->{$fieldname} = $fieldvalue;
			} else {
				$this->unknown_core_fields[] = $fieldname;
				$this->unknown_core_fields_warning = true;
			}
		}

		return $user;
	}

	// Returns an array of profile fields with the array key set as the field's shortname
	// otherwise it returns an empty array.
	function _get_user_info_fields($userid = 0) {
		if ($fields = $this->DB->get_records('user_info_field')) {
			$form_fields = array();
			foreach ($fields as $field) {
				require_once($this->CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
				$newfield = 'profile_field_'.$field->datatype;
				$formfield = new $newfield($field->id, $userid);
				$form_fields[$field->shortname] = $formfield;
			}
			return $form_fields;
		}
		return array();
	}

	// Returns an object with a users profile field data
	function get_user_info_fields($userid) {
		// error_reporting(E_ALL ^ E_NOTICE);
		$user_profile_fields = new stdClass();
		if ($fields = $this->_get_user_info_fields($userid)) {
			foreach ($fields as $shortname => $field) {
				$user_profile_fields->{$shortname} = $field->data;
			}
		}
		return $user_profile_fields;
	}

	// Check that the profile fields that are sent exist in moodle
	function _user_validate_profile_fields($user_profile_fields) {
		$fields = $this->_get_user_info_fields();
		// Create a list of any sent fields that don't exist in moodle
		foreach ($user_profile_fields as $fieldname => $fieldvalue) {
			if (!array_key_exists($fieldname, $fields)) {
				$this->missing_profile_fields[] = $fieldname;
				$this->missing_profile_fields_warning = true;
			}
		}
		return true;
	}

	function _user_save_profile_fields($userid, $user_profile_fields) {
		// $formfield->edit_save_data expects the userid to be a part of the fields object
		$profile_fields = new stdClass();
		$profile_fields->id = $userid;
		// $formfield->edit_save_data expects profile fields to be prefix with 'profile_field_'
		foreach ($user_profile_fields as $fieldname => $fieldvalue) {
			$profile_fields->{'profile_field_' .$fieldname} = $fieldvalue;
		}
		// Pass the profile_fields collection to each field for it to pick out the value it wants
		if ($fields = $this->_get_user_info_fields($userid)) {
			foreach ($fields as $field) {
				$classname = get_class($field);
				$field_shortname = $field->field->shortname;
				if ($classname == "profile_field_menu") { // Convert the value into the offset, rather than the given string
					if (array_key_exists($field_shortname, $user_profile_fields)) {
						$user_field_value = $user_profile_fields[$field_shortname];
						// IMPORTANT: We must save the key for a menu item, not the string itself.
						$option_key = array_search($user_field_value, $field->options);

						if ($option_key === false) {
							// The value sent over the wire is unknown, and has no key for the value in the menu
							// Don't set, and allow moodle itself to collect correct value
							$this->missing_profile_fields[] = 'Menu field: ' .$field_shortname .' Value not found: ' .$user_field_value .' option_key is false';
							$this->missing_profile_fields_warning = true;
							continue; // Skip to the next field
						} else if ($option_key === null) {
							// The value sent over the wire is unknown, and has no key for the value in the menu
							// Don't set, and allow moodle itself to collect correct value
							$this->missing_profile_fields[] = 'Menu field: ' .$field_shortname .' Value not found: ' .$user_field_value .' option_key is null';
							$this->missing_profile_fields_warning = true;
							continue; // Skip to the next field
						} else {
							// Set known offset value.
							$profile_fields->{'profile_field_' .$field_shortname} = $option_key;
							try {
								$field->edit_save_data($profile_fields);
							} catch (Exception $e) {
								$this->missing_profile_fields[] = 'Menu field: ' .$field_shortname .' Exception: ' .substr(print_r($e, true), 0, 5000);
								$this->missing_profile_fields_warning = true;
							}
						}
					} else {
						$this->missing_profile_fields[] = 'Menu field: ' .$field_shortname .' Not found in user_profile_data';
						$this->missing_profile_fields_warning = true;
						continue;
					}
				} else {
					try {
						$field->edit_save_data($profile_fields);
					} catch (Exception $e) {
						$this->missing_profile_fields[] = 'Field: ' .$field_shortname .' Exception: ' .substr(print_r($e, true), 0, 5000);
						$this->missing_profile_fields_warning = true;
					}
				}
			}
		}
	}

// Enrollments

	function user_reenrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds) {
		// By default just call through to the normal enrol method
		return $this->user_enrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds);
	}

	function user_reenrol_course_by_shortname_extended($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		// By default just call through to the normal enrol method
		return $this->user_enrol_course_by_shortname_extended($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	function user_enrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds) {
		// Setup some default values for compatibility with the _user_enrol_course() additions
		$use_role_name = false;
		$role_name = null;
		$enrol_in_group = false;
		$group_name = null;
		$use_start_time = false;
		$start_time_unix = null;
		return $this->_user_enrol_course($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	function user_enrol_course_by_shortname_extended($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		return $this->_user_enrol_course($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	function user_enrol_courses_by_shortnames($user_id, $course_shortnames, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		if ($course_shortnames == false) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required.');
		}
		if (is_array($course_shortnames) == false) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required to be array.');
		}
		if (count($course_shortnames) == 0) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required to be non-empty array.');
		}
		$results = array();
		foreach ($course_shortnames as $course_shortname) {
			$enrol_result = new stdClass();
			$enrol_result->success = null;
			$enrol_result->error_code = null;
			$enrol_result->error_message = null;
			try {
				$enrol_result->success = $this->_user_enrol_course($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
				$results[$course_shortname] = $enrol_result;
			} catch (Exception $e) {
				$enrol_result->success = false;
				$enrol_result->error_code = $e->getCode();
				$enrol_result->error_message = $e->getMessage();
				$results[$course_shortname] = $enrol_result;
			}
		}
		return $results;
	}

	function _user_enrol_course($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		$course = $this->DB->get_record('course', array('shortname' => $course_shortname));
		if ($course == false) {
			$this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by shortname: ' .$course_shortname);
		}

		if (is_object($course) == false) {
			$this->cm_throw(self::COURSE_REQUIRED, 'Course object required.');
		}

		$instance = $this->DB->get_record('enrol', array('courseid'=>$course->id,'enrol'=>'manual'),'*');
		if ($instance == false) {
			$this->cm_throw(self::NO_ENROLMENT_MODULE, 'Unable to locate appropriate enrolment module.');
		}
		//error_log('Course:' .print_r($course, true));
		$roleid = $instance->roleid;
		if ($use_role_name) {
			$role = $this->_get_role_shortname($role_name);
			//error_log('Role:' .print_r($role, true));
			if ($role == false) {
				$this->cm_throw(self::ROLE_NOT_FOUND, 'Role not found by shortname: ' .$role_name);
			}
			$roleid = $role->id;
		}

		if (!$enrol_manual = enrol_get_plugin('manual')) {
			throw new coding_exception('Can not instantiate enrol_manual');
		}

		$context = $this->_get_context_course($course->id);
		//error_log('Context:' .print_r($context, true));

		// If duration it set use it, otherwise use the
		// enrol period specified in the moodle course settings.
		if ($use_enrol_period) {
			$enrol_period = $enrol_period_seconds;
		} else {
			// $enrol_period = $course->enrolperiod;
			$enrol_period = $instance->enrolperiod;
		}

		// Check if we're already enrolled, and the timeend has not passed, if so add our enrolperiod to the existing timeend
		if ($ra = $this->DB->get_record('user_enrolments', array('enrolid'=>$instance->id, 'userid'=>$user_id))) {
			// treat as expired if end timestamp > 1 day (to allow for timezone variations) and has passed.
			$isEndless = ($ra->timeend <= 24*60*60); // should really be 0;
			$isExpired = !$isEndless && ($ra->timeend < time());
			if (($allow_extend_enrol_period == false) && (!$isExpired)) {
				return self::ROLE_NOT_EXTENDED;
			}
			if ($use_start_time == false) {
				$start_time_unix = $ra->timestart;
			}
			if (($enrol_period == 0) || $isEndless) {
				$end_time_unix = 0; // unlimited enrollment if requested or already endless.
			} else {
				if ($isExpired || $isEndless) {
					$end_time_unix = mktime(0,0,0,date("n"),date("j"),date("Y")) + $enrol_period;	// expired or no end time set, period from now.
				} else {
					$end_time_unix = $ra->timeend + $enrol_period;	// extend existing time.
				}
			}
		} else {
			// new enrolment
			if ($use_start_time == false) {
				$start_time_unix = mktime(0,0,0,date("n"),date("j"),date("Y"));
			}
			if ($enrol_period == 0) {
				$end_time_unix = 0; // unlimited enrollment
			} else {
				$end_time_unix = $start_time_unix + $enrol_period;
			}
		}

		// enrol the user onto the course with the calculated settings, forcing the enrolment to active in case a suspended verion exists.
		if ($return = $this->_user_enrol_in_instance_mdl2($enrol_manual, $instance, $user_id, $roleid, $start_time_unix, $end_time_unix, true)) {
			if ($enrol_in_group) {
				$return = $this->_add_to_group($course->id, $user_id, $group_name);
			}
			return $return;
		} else {
			$this->cm_throw(self::ENROL_FAILED, "Failed to enrol user: roleid:$roleid, userid:$user_id, contextid:$context->id, start_time_unix:$start_time_unix, end_time_unix:$end_time_unix");
		}
	}

	protected function _add_to_group($course_id, $user_id, $group_name) {
		global $CFG;
		require_once($CFG->dirroot . '/group/lib.php');

		$group_id = groups_get_group_by_name($course_id, $group_name);
		if ($group_id === false) {
			$group_id = $this->_create_new_group($course_id, $group_name);
		}
		groups_add_member($group_id, $user_id);
	}

	public function courses_groups_create_by_shortnames($groups, $course_shortnames) {
		global $CFG;
		require_once($CFG->dirroot . '/group/lib.php');

		if ($groups == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'groups parameter required.');
		}
		if (is_array($groups) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'groups parameter required to be array.');
		}
		if (count($groups) == 0) {
			$this->cm_throw(self::PARAMETER_ERROR, 'group_names parameter required to be non-empty array.');
		}

		$groups_results = array();
		foreach ($groups as $group) {
			$cm_group_id = $group['cm_group_id'];
			$groups_results[$cm_group_id] = $this->_create_new_group_course_shortnames($group['name'], $course_shortnames);
		}
		return $groups_results;
	}

	protected function _create_new_group_course_shortnames($group_name, $course_shortnames) {
		if ($course_shortnames == false) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required.');
		}
		if (is_array($course_shortnames) == false) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required to be array.');
		}
		if (count($course_shortnames) == 0) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortnames parameter required to be non-empty array.');
		}
		$courses_results = array();
		foreach ($course_shortnames as $course_shortname) {
			$result = new stdClass();
			$result->success = null;
			$result->error_code = null;
			$result->error_message = null;
			try {
				$result->success = $this->_create_new_group_course_shortname($group_names, $course_shortname);
				$results[$course_shortname] = $enrol_result;
			} catch (Exception $e) {
				$result->success = false;
				$result->error_code = $e->getCode();
				$result->error_message = $e->getMessage();
				$courses_results[$course_shortname] = $enrol_result;
			}
		}
		return $courses_results;
	}

	// Get the Course ID from the shortname and creates the group.
	protected function _create_new_group_course_shortname($group_name, $course_shortname) {
		if (empty($course_shortname)) {
			$this->cm_throw(self::COURSE_REQUIRED, 'course_shortname parameter required.');
		}

		if (($course = $this->DB->get_record('course', array('shortname' => $course_shortname))) == false){
			$this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by shortname: ' .$course_shortname);
		}
		return $this->_create_new_group($course_id, $group_name);
	}

	protected function _create_new_group($course_id, $group_name) {

		// If the group already exists return it.
		$group_id = groups_get_group_by_name($course_id, $group_name);
		if ($group_id) {
			return $group_id;
		}

		$newgroup = new stdClass();
		$newgroup->courseid = $course_id;
		$newgroup->name = $group_name;
		$group_id = groups_create_group($newgroup);
		return $group_id;
	}

	function _user_enrol_in_instance_mdl2($enrol_plugin, $instance, $user_id, $role_id, $start_time_unix, $end_time_unix, $forceActive) {
		if ($forceActive) {
			$enrol_plugin->enrol_user($instance, $user_id, $role_id, $start_time_unix, $end_time_unix, ENROL_USER_ACTIVE);
		} else {
			$enrol_plugin->enrol_user($instance, $user_id, $role_id, $start_time_unix, $end_time_unix);
		}
		return true;
	}

	function _get_role_shortname($role_shortname) {
		return $this->DB->get_record('role', array('shortname' => $role_shortname));
	}

	function _get_context_course($course_id) {
		return context_course::instance($course_id);
	}

	function _get_context_course_by_shortname($course_shortname) {
		if (($course = $this->DB->get_record('course', array('shortname' => $course_shortname))) == false) {
			return false;
			// $this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by shortname: ' .$course_shortname);
		}
		return context_course::instance($course->id);
	}

	function _user_enrolled_in_course_context($user_id, $course_context, $role) {
		if (empty($user_id)) {
			$this->cm_throw(self::PARAMETER_ERROR, 'user_id required.');
		}
		if (is_object($course_context) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'Course Context required.');
		}
		if (is_object($role) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'Role required.');
		}

		if ($ra = $this->DB->get_record('role_assignments', array('roleid' => $role->id, 'contextid' => $course_context->id, 'userid' => $user_id))) {
			return true;
		}
		return false;
	}

	function _user_enrolled_in_course_contexts($user_id, $course_contexts, $role) {
		if (empty($user_id)) {
			$this->cm_throw(self::PARAMETER_ERROR, 'user_id required.');
		}
		if (is_array($course_contexts) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'Course Contexts required to be an array.');
		}
		if (is_object($role) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'Role required.');
		}

		$enrolled = true;
		foreach($course_contexts as $course_context) {
			if ($this->_user_enrolled_in_course_context($user_id, $course_context, $role) == false) {
				$enrolled = false;
			}
		}
		return $enrolled;
	}

	// Check if an array of users are enrolled in all the supplied array of courses
	// return an array of user ids that are enrolled in all requested courses.
	function users_enrolled_in_course_by_shortnames($user_ids, $course_shortnames, $role_name) {
		if (is_array($user_ids) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'user_ids required to be an array.');
		}
		if (is_array($course_shortnames) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'course_shortnames required to be an array.');
		}

		if (($role = $this->_get_role_shortname($role_name)) ==  false) {
			$this->cm_throw(self::ROLE_NOT_FOUND, 'Role not found by shortname: ' .$role_name);
		}
		$course_contexts = array();
		foreach($course_shortnames as $course_shortname) {
			if ($course_context = $this->_get_context_course_by_shortname($course_shortname)) {
				$course_contexts[] = $course_context;
			} else {
				// If a courses doesn't exist the student can't be enrolled in all requested courses so return early.
				$this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by ' .$course_shortname);
			}
		}
		$enrolled_users = array();
		foreach($user_ids as $user_id) {
			if ($this->_user_enrolled_in_course_contexts($user_id, $course_contexts, $role)) {
				$enrolled_users[] = $user_id;
			}
		}
		return $enrolled_users;
	}

	// Return an array of user ids that are enrolled in requested course matching the role_name.
	function users_enrolled_in_course_by_shortname($course_shortname, $role_name) {
		if (empty($course_shortname)) {
			$this->cm_throw(self::PARAMETER_ERROR, 'course_shortname required.');
		}

		if (($role = $this->_get_role_shortname($role_name)) ==  false) {
			$this->cm_throw(self::ROLE_NOT_FOUND, 'Role not found by shortname: ' .$role_name);
		}

		if ($course_context = $this->_get_context_course_by_shortname($course_shortname)) {
			$sql = "SELECT musr.*
					FROM {role_assignments} ra
					JOIN {user} musr ON ra.userid = musr.id
					WHERE ra.roleid=? AND ra.contextid=?";
			try {
				// error_reporting(E_ALL | E_NOTICE);
				$users = $this->DB->get_records_sql($sql, array($role->id, $course_context->id));
			} catch (Exception $e) {
				// error_log($e);
				throw $e;
			}
			if ($users) {
				return $users;
			}
		} else {
			// If a courses doesn't exist the student can't be enrolled in all requested courses so return early.
			$this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by ' .$course_shortname);
		}
		return false;
	}

// Grades

	function grades_get_by_users_courses($user_ids, $course_shortnames) {
		// error_reporting(E_ALL | E_NOTICE);
		if (is_array($user_ids) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'user_ids required to be an array.');
		}
		if (is_array($course_shortnames) == false) {
			$this->cm_throw(self::PARAMETER_ERROR, 'course_shortnames required to be an array.');
		}

		// $item = new object();
		// $item->scaleid    = $grade_item->scaleid;
		// $item->name       = $grade_item->get_name();
		// $item->grademin   = $grade_item->grademin;
		// $item->grademax   = $grade_item->grademax;
		// $item->gradepass  = $grade_item->gradepass;
		// $item->locked     = $grade_item->is_locked();
		// $item->hidden     = $grade_item->is_hidden();
		// $item->grades     = array();

		// $grade = new object();
		// $grade->grade          = $grade_grades[$userid]->finalgrade;
		// $grade->locked         = $grade_grades[$userid]->is_locked();
		// $grade->hidden         = $grade_grades[$userid]->is_hidden();
		// $grade->overridden     = $grade_grades[$userid]->overridden;
		// $grade->feedback       = $grade_grades[$userid]->feedback;
		// $grade->feedbackformat = $grade_grades[$userid]->feedbackformat;
		// $grade->usermodified   = $grade_grades[$userid]->usermodified;
		// $grade->dategraded     = $grade_grades[$userid]->get_dategraded();
		// $grade->str_grade = grade_format_gradevalue($grade->grade, $grade_item);
		// $grade->str_long_grade = $grade->str_grade;

		// $item->grades[$userid] = $grade;

		$CFG = $this->CFG;
		require_once($CFG->libdir . '/gradelib.php');
		require_once($CFG->dirroot . '/grade/querylib.php');

		$courses_grades = array();
		foreach ($course_shortnames as $course_shortname) {
			if (($course = $this->DB->get_record('course', array('shortname' => $course_shortname))) == false){
				$this->cm_throw(self::COURSE_NOT_FOUND, 'Course not found by shortname: ' .$course_shortname);
			}
			$course_grades = grade_get_course_grades($course->id, $user_ids);
			// Hack - replace grades array with new array where the userid index is prefix by the string 'user_id_'
			// this is because in the XML_RPC return the integer only userids were being treated as a plain array
			// rather than an associative array so they were lost in transmission, the array that was received on
			// the other side started with index [0]
			$grades_temp = array();
			foreach ($course_grades->grades as $user_id => $grade) {
				$grades_temp['user_id_' .$user_id] = $grade;
			}
			$course_grades->grades = $grades_temp;
			// End Hack
			$courses_grades[$course_shortname] = $course_grades;
		}
		// error_log('$course_grades' .print_r($courses_grades, true));
		return $courses_grades;
	}


// License Group

	function license_group_get_by_id($license_group_id) {
		$this->cm_throw(self::NOT_IMPLEMENTED_ERROR, __METHOD__ .' NOT IMPLEMENTED');
	}

	function license_group_get_by_code($license_group_code) {
		$this->cm_throw(self::NOT_IMPLEMENTED_ERROR, __METHOD__ .' NOT IMPLEMENTED');
	}

	function license_group_create($license_group_name, $license_group_code) {
		$this->cm_throw(self::NOT_IMPLEMENTED_ERROR, __METHOD__ .' NOT IMPLEMENTED');
 	}

	function license_group_add_user($license_group_id, $user_id) {
		$this->cm_throw(self::NOT_IMPLEMENTED_ERROR, __METHOD__ .' NOT IMPLEMENTED');
	}

	function license_group_add_course_licenses_by_shortname($license_group_id, $course_shortname, $use_default_enrol_period, $enrol_period_seconds) {
		$this->cm_throw(self::NOT_IMPLEMENTED_ERROR, __METHOD__ .' NOT IMPLEMENTED');
	}

// Courses

	function categories_get($parent_category_id) {
		global $CFG;

		if ($parent_category_id != "" && is_numeric($parent_category_id)) {
			$categoryselect = "WHERE c.parent = '$parent_category_id'";
		} else {
			$categoryselect = "";
		}

		$fields="c.id, c.name, c.parent, c.visible, c.timemodified";
		$sortstatement = "ORDER BY c.name ASC";

		// pull out all course matching the cat
		if ($courses = $this->DB->get_records_sql("SELECT $fields
										FROM {$CFG->prefix}course_categories c
										$categoryselect
										$sortstatement")) {

			return $courses;
		}
		return false;
	}

	function courses_get($category_id) {
		global $CFG;

		if ($category_id != "" && is_numeric($category_id)) {
			$categoryselect = "WHERE c.category = '$category_id'";
		} else {
			$categoryselect = "";
		}

		$fields="c.id, c.category, c.shortname, c.fullname, c.visible, c.timemodified";
		$sortstatement = "ORDER BY c.fullname ASC";

		// pull out all course matching the cat
		if ($courses = $this->DB->get_records_sql("SELECT $fields
										FROM {$CFG->prefix}course c
										$categoryselect
										$sortstatement")) {

			return $courses;
		}
		return false;
	}

	function get_plugin_version() {
		$plugin = new stdClass();
		include dirname(__FILE__) .'/../version.php';
		return $plugin;
	}

}
