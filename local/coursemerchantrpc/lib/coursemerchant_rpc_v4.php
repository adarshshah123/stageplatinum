<?php   /// $Id$
///////////////////////////////////////////////////////////////////////////
//                                                                       //
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// Moodle - Modular Object-Oriented Dynamic Learning Environment         //
//          http://moodle.org                                            //
//                                                                       //
// Copyright (C) 2004  Martin Dougiamas  http://moodle.com               //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

require_once(dirname(__FILE__) .'/lib.php');
// error_reporting(E_ALL ^ E_NOTICE);

class coursemerchant_rpc_v4 {

var $errormsg;

	function __construct() {
		// error_reporting(E_ALL ^ E_NOTICE);
		$this->cm_rpc_v4 = new cm_rpc_v4();
	}

	/**
	* Get a list of users by column name and values
	* Returns an array of user's core fields as specified in $return_fields
	* @param string $column_name - column to query
	* @param array $field_values - values to match on
	* @param array $return_fields - list of columns to return
	* @return array
	*/
	function users_get($column_name, $field_values, $return_fields) {
		return $this->cm_rpc_v4->users_get_by_column_values($column_name, $field_values, $return_fields);
	}

	/**
	* Get a user 
	* Returns a user array containing user core fields sub-array and user profile fields sub-array
	* @param string $column_name - column to query
	* @param array $field_value - value to match on
	* @return array
	*/
	function user_get($column_name, $field_value) {
		return $this->cm_rpc_v4->user_get_complete($column_name, $field_value);
	}

	/**
	* Get a user 
	* Returns a user array containing user core fields sub-array and user profile fields sub-array
	* @param string $userid - user id to match on
	* @return array
	*/
	function user_get_by_id($userid) {
		return $this->cm_rpc_v4->user_get_complete('id', $userid);
	}

	/**
	* Get a user 
	* Returns a user array containing user core fields sub-array and user profile fields sub-array
	* @param string $username - username to match on
	* @return array
	*/
	function user_get_by_username_cas_sso($username) {
		return $this->cm_rpc_v4->user_get_by_username_cas_sso($username);
	}

	/**
	* Get a user 
	* Returns a user array containing user core fields sub-array and user profile fields sub-array
	* @param string $username - user id to match on
	* @return array
	*/
	function user_check_exists($username) {
		return $this->cm_rpc_v4->user_check_exists($username);
	}

	/**
	* Checks if a username and password is correct
	* Returns true or false as int 0 or 1
	* @param string $username - user id to match on
	* @param string $password - password to test
	* @return int - 0 or 1
	*/
	function user_check_credentials($username, $password) {
		return $this->cm_rpc_v4->user_check_credentials($username, $password) ? true : false;
	}

	/**
	* Checks if a username and password is correct and return the user
	* Returns an array with the result and if true a user array containing user core fields sub-array and user profile fields sub-array
	* @param string $username - user id to match on
	* @param string $password - password to test
	* @return array
	*/
	function user_get_check_credentials($username, $password) {
		return $this->cm_rpc_v4->user_check_credentials($username, $password);
	}

	/**
	* Create a user
	* Returns userid or false (0)
	* @param object|struct $user_core_fields - user core fields
	* @param object|struct $user_profile_fields - user core fields
	* @param string $password - password 
	* @param int $check_password_policy - 
	* @return
	*/
	function user_create($user_core_fields, $user_profile_fields, $password, $check_password_policy) {
		return $this->cm_rpc_v4->user_create($user_core_fields, $user_profile_fields, $password, $check_password_policy);
	}

	/**
	* Update a user
	* Returns userid or false (0)
	* @param string $user_id - user id to update
	* @param object|struct $user_core_fields - user core fields
	* @param object|struct $user_profile_fields - user core fields
	* @return
	*/
	function user_update($user_id, $user_core_fields, $user_profile_fields) {
		return $this->cm_rpc_v4->user_update($user_id, $user_core_fields, $user_profile_fields);
	}

	/**
	* Force a user to reset their password
	* Returns true (1) for success or throws on failure per the moodle internal function that is called
	* @param string $user_id - user id to update
	* @return
	*/
	function user_force_password_change($user_id) {
		return $this->cm_rpc_v4->user_force_password_change($user_id);
	}

	/**
	* Check if a list of user ids are enrolled in a list of course shortnames
	* Returns true or false
	* @param array $user_ids - user ids
	* @param array $course_shortnames - 
	* @param string $role_name - role name to use (usually 'student')
	* @return int - 0 or 1
	*/
	function users_enrolled_in_course_by_shortnames($user_ids, $course_shortnames, $role_name) {
		return $this->cm_rpc_v4->users_enrolled_in_course_by_shortnames($user_ids, $course_shortnames, $role_name);
	}

	/**
	* Return an array of user ids that are enrolled in requested course matching the role_name.
	* Returns array of user info
	* @param array $course_shortname - course shortname to list
	* @param string $role_name - role name to use (usually 'student')
	* @return array - array of user info.
	*/
	function users_enrolled_in_course_by_shortname($course_shortname, $role_name) {
		return $this->cm_rpc_v4->users_enrolled_in_course_by_shortname($course_shortname, $role_name);
	}

	/**
	* Enrol a user in a course by it's shortname
	* Returns true or false
	* @param int $user_id - user id
	* @param string $course_shortname - 
	* @param int $allow_extend_enrol_period - if the user is already enrolled should their enrolment be extended or replaced
	* @param int $use_enrol_period - whether to use the course default enrol period or the enrol period supplied with this call
	* @param int $enrol_period_seconds - length in seconds of the enrol period
	* @param string $role_name - role name to use (usually 'student')
	* @return int - 0 or 1
	*/
	function user_enrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $role_name) {
		// role_name was never used, it's been dropped by the implementation method,
		// the new _extended method does however support role_name.
		return $this->cm_rpc_v4->user_enrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds);
	}


	/**
	* Enrol a user in a course by it's shortname
	* Returns true or false
	* @param int $user_id - user id
	* @param string $course_shortname - 
	* @param int $allow_extend_enrol_period - if the user is already enrolled should their enrolment be extended or replaced
	* @param int $use_enrol_period - whether to use the course default enrol period or the enrol period supplied with this call
	* @param int $enrol_period_seconds - length in seconds of the enrol period
	* @param string $role_name - role name to use (usually 'student')
	* @param int $enrol_in_group - whether to enrol in a group
	* @param string $group_name - group name to use, will be created if it doesn't exist
	* @return int - 0 or 1
	*/
	function user_enrol_course_by_shortname_extended($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		return $this->cm_rpc_v4->user_enrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	/**
	* Enrol a user in courses by shortnames
	* Returns array of result data
	* @param int $user_id - user id
	* @param array $course_shortnames - array of course shortnames
	* @param int $allow_extend_enrol_period - if the user is already enrolled should their enrolment be extended or replaced
	* @param int $use_enrol_period - whether to use the course default enrol period or the enrol period supplied with this call
	* @param int $enrol_period_seconds - length in seconds of the enrol period
	* @param string $role_name - role name to use (usually 'student')
	* @param int $enrol_in_group - whether to enrol in a group
	* @param string $group_name - group name to use, will be created if it doesn't exist
	* @return array - result array - keyed by course shortname with success and error status.
	*/
	function user_enrol_courses_by_shortnames($user_id, $course_shortnames, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		return $this->cm_rpc_v4->user_enrol_courses_by_shortnames($user_id, $course_shortnames, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	/**
	* Enrol a user in a course by it's shortname
	* Returns true or false
	* @param int $user_id - user id
	* @param string $course_shortname - 
	* @param int $allow_extend_enrol_period - if the user is already enrolled should their enrolment be extended or replaced
	* @param int $use_enrol_period - whether to use the course default enrol period or the enrol period supplied with this call
	* @param int $enrol_period_seconds - length in seconds of the enrol period
	* @param string $role_name - role name to use (usually 'student')
	* @return int - 0 or 1
	*/
	function user_reenrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $role_name) {
		// role_name was never used, it's been dropped by the implementation method,
		// the new _extended method does however support role_name.
		return $this->cm_rpc_v4->user_reenrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds);
	}

	/**
	* Enrol a user in a course by it's shortname
	* Returns true or false
	* @param int $user_id - user id
	* @param string $course_shortname - 
	* @param int $allow_extend_enrol_period - if the user is already enrolled should their enrolment be extended or replaced
	* @param int $use_enrol_period - whether to use the course default enrol period or the enrol period supplied with this call
	* @param int $enrol_period_seconds - length in seconds of the enrol period
	* @param string $role_name - role name to use (usually 'student')
	* @param int $enrol_in_group - whether to enrol in a group
	* @param string $group_name - group name to use, will be created if it doesn't exist
	* @return int - 0 or 1
	*/
	function user_reenrol_course_by_shortname_extended($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix) {
		return $this->cm_rpc_v4->user_reenrol_course_by_shortname($user_id, $course_shortname, $allow_extend_enrol_period, $use_enrol_period, $enrol_period_seconds, $use_role_name, $role_name, $enrol_in_group, $group_name, $use_start_time, $start_time_unix);
	}

	/**
	* Get course grade for a list of user ids and a list of course shortnames
	* Returns true or false
	* @param array $user_ids - user ids
	* @param array $course_shortnames - 
	* @return int - 0 or 1
	*/
	function grades_get_by_users_courses($user_ids, $courses_shortnames) {
		return $this->cm_rpc_v4->grades_get_by_users_courses($user_ids, $courses_shortnames);
	}

	/**
	* Get a license group by id
	* Returns true or false
	* @param string $license_group_id -
	* @return array
	*/
	function license_group_get_by_id($license_group_id) {
		return $this->cm_rpc_v4->license_group_get_by_id($license_group_id);
	}

	/**
	* Get a license group by code
	* Returns true or false
	* @param string $license_group_code -
	* @return array
	*/
	function license_group_get_by_code($license_group_code) {
		return $this->cm_rpc_v4->license_group_get_by_code($license_group_code);
	}

	/**
	* Create a license group
	* Returns true or false
	* @param string $license_group_name -
	* @param string $license_group_code -
	* @return array
	*/
	function license_group_create($license_group_name, $license_group_code) {
		return $this->cm_rpc_v4->license_group_create($license_group_name, $license_group_code);
	}

	/**
	* Add a user to a license group
	* Returns true or false
	* @param string $license_group_id -
	* @param string $user_id -
	* @return int
	*/
	function license_group_add_user($license_group_id, $user_id) {
		return $this->cm_rpc_v4->license_group_add_user($license_group_id, $user_id);
	}

	/**
	* Add licenses to a license group
	* Returns true or false
	* @param string $license_group_id -
	* @param string $course_shortname -
	* @param int $licenses -
	* @param int $use_default_enrol_period -
	* @param int $enrol_period_seconds -
	* @return int
	*/
	function license_group_add_course_licenses_by_shortname($license_group_id, $course_shortname, $licenses, $use_default_enrol_period, $enrol_period_seconds) {
		return $this->cm_rpc_v4->license_group_add_course_licenses_by_shortname($license_group_id, $course_shortname, $licenses, $use_default_enrol_period, $enrol_period_seconds);
	}

	/**
	* Get a list of course categories
	* Returns an array of user's core fields as specified in $return_fields
	* @param string $parent_category_id - get children of id, can be empty to get all
	* @return array
	*/
	function categories_get($parent_category_id) {
		return $this->cm_rpc_v4->categories_get($parent_category_id);
	}

	/**
	* Get a list of courses
	* Returns an array of user's core fields as specified in $return_fields
	* @param string $category_id - get courses for category id, can be empty to get all
	* @return array
	*/
	function courses_get($category_id) {
		return $this->cm_rpc_v4->courses_get($category_id);
	}

	/**
	* Create a number of groups in a set of courses.
	* Returns true or false
	* @param array $group_names - groups to add
	* @param array $course_shortnames - array of course shortnames
	* @return array - result array - keyed by course shortname with success and error status.
	*/
	function courses_groups_create_by_shortnames($groups, $course_shortnames) {
		return $this->cm_rpc_v4->courses_groups_create_by_shortnames($groups, $course_shortnames);
	}

	/**
	* Get the version of the plugin
	* Returns stdObject with plugin version fields
	* @return stdObject - with plugin version fields
	*/
	function get_plugin_version() {
		return $this->cm_rpc_v4->get_plugin_version();
	}

} /// end of class
