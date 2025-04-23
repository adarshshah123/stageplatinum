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
 * Form for editing earned certificate block instances.
 *
 * @package   block_earned_certificates
 * @copyright 2019 MLC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/blocks/edit_form.php');

/**
 * Form for editing earned certificate block instances.
 *
 * @package   block_earned_certificates
 * @copyright 2019 MLC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_earned_certificates_edit_form extends block_edit_form {

    /**
     * @param MoodleQuickForm $mform
     * @throws coding_exception
     */
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_perpage', get_string('perpage', 'block_earned_certificates'));
        $mform->setType('config_perpage', PARAM_TEXT);
        $mform->addHelpButton('config_perpage', 'perpage', 'block_earned_certificates');
        $mform->setDefault('config_perpage', block_earned_certificates::DEFAULT_PER_PAGE);
    }
}
