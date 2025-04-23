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
 * Settings for the Course Merchant Auth plugin
 * These are accessed via the $CFG global
 *
 * @package    coursemerchant
 * @copyright  2013 Connected Shopping Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

// CM Integration settings page
$settings->add(new admin_setting_configtext('auth_coursemerchant_sso_key', get_string('cm_sso_key', 'auth_coursemerchant'), get_string('cm_sso_key_description', 'auth_coursemerchant'), '', PARAM_TEXT));
$settings->add(new admin_setting_configtext('auth_coursemerchant_cm_base_url', get_string('cm_base_url', 'auth_coursemerchant'), get_string('cm_base_url_description', 'auth_coursemerchant'), '', PARAM_TEXT));
