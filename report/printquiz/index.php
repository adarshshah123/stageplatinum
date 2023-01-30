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
 * This a printable quiz of a particular quiz attempt
 *
 * @package   report_printquiz
 * @copyright 2019 MLC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

$attemptid = required_param('attempt', PARAM_INT);
$cmid      = optional_param('cmid', null, PARAM_INT);

$PAGE->set_pagelayout('print');
$url = new moodle_url('/report/printquiz/index.php', ['attempt' => $attemptid]);
$PAGE->set_url($url);

$attemptobj = quiz_create_attempt_handling_errors($attemptid, $cmid);

if (!$attemptobj->is_own_attempt()) {
    throw new moodle_exception('invalidattempt', 'report_printquiz');
}

$page = $attemptobj->force_page_number_into_range(0);

// Check login.
require_login($attemptobj->get_course(), false, $attemptobj->get_cm());
$attemptobj->check_review_capability();

$options = $attemptobj->get_display_options(true);

// Set up the page header.
$PAGE->set_title($attemptobj->get_quiz_name());
$PAGE->set_heading($attemptobj->get_course()->fullname);

$slots = $attemptobj->get_slots();

$output = $PAGE->get_renderer('mod_quiz');
echo $output->review_page($attemptobj, $slots, 0, true, false, $options, []);
echo html_writer::div(
    html_writer::link('javascript:window.print()',
        get_string('printpage', 'report_printquiz')
    ), 'print-link');

\report_printquiz\event\report_viewed::create(['other' => ['attemptid' => $attemptid]])->trigger();
