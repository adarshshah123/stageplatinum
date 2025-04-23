<?php

/**
 * Add CM administration menu settings
 */
 
if ($hassiteconfig) { // speedup for non-admins, add all caps used on this page
	$ADMIN->add('localplugins',
		new admin_category('local_cm_enrol_rpc',
		'Course Merchant')
	);

	if (isset($CFG->local_cm_enrol_rpc_token) == false || empty($CFG->local_cm_enrol_rpc_token) == true) {
		$new_token = md5(random_string(32));
		set_config('local_cm_enrol_rpc_token', $new_token);
	}

	// CM Integration settings page
	$temp = new admin_settingpage('local_cm_enrol_rpc_settings', 'RPC Integration Settings');
	$temp->add(new admin_setting_configcheckbox('local_cm_enrol_rpc_enabled', 'Enable Course Merchant RPC Integration', 'Enable Course Merchant RPC Integration', 0));
	$temp->add(new admin_setting_configtext('local_cm_enrol_rpc_username', 'Moodle Username for module', 'Either create a new user account for the module with admin capabilities or leave as admin.', 'admin', PARAM_TEXT));
	$temp->add(new admin_setting_configtext('local_cm_enrol_rpc_token', 'Course Merchant API Token', 'Enter the Course Merchant API Token', '', PARAM_TEXT, 50));

	$ADMIN->add('local_cm_enrol_rpc', $temp);

} // end of speedup
