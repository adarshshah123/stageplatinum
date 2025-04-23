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
 * Version file for this plugin
 *
 * @package    coursemerchant
 * @copyright  2013-2018 Connected Shopping Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$plugin->version  = 2018052100;   // The (date) version of this plugin
$plugin->requires = 2017111300;	// Requires this Moodle version. At least Moodle3.4, as the privacy definition requires PHP7

// Now required by moodle 3, but in the code since moodle 2
$plugin->component = 'local_coursemerchantrpc';

