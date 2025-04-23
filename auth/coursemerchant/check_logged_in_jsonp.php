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

define('NO_DEBUG_DISPLAY', true);
require('../../config.php');
require_once($CFG->dirroot.'/auth/coursemerchant/lib.php');

header('Content-Type: text/javascript');

global $CFG;

$PAGE->set_context(context_system::instance());

// check module is active
if (!is_enabled_auth('coursemerchant')) {
	return;
}

try {
	cm_sso_helper::check_logged_in_json();
} catch (Exception $e) {
	cm_sso_helper::cm_add_to_log(SITEID, 'coursemerchant', 'sso', '', "SSO: check_logged_in_json: " .$e->getMessage(), 0, 0);
	debugging("Error: auth/coursemerchant sso check_logged_in_json: " .print_r($e, true), DEBUG_DEVELOPER);
}