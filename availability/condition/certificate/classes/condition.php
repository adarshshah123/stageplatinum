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
 * Certificate condition.
 *
 * @package availability_certificate
 * @copyright 2019 My Learning Consultants
 * @author Joseph Conradt
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_certificate;

defined('MOODLE_INTERNAL') || die();

class condition extends \core_availability\condition {

    private $certificate_id;

    public function __construct($structure) {
        $this->certificate_id = $structure->certificate_id;
    }

    public function save() {
        // Save back the data into a plain array similar to $structure above.
        return (object)array('type' => 'certificate', 'certificate_id' => $this->certificate_id);
    }

    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        global $CFG;

        require_once("$CFG->dirroot/mod/certificate/locallib.php");

        $allowed = false;

        // Check if user has previously issued certificate.
        if (certificate_get_attempts($this->certificate_id)) {
            $allowed = true;
        }

        // Negate if "not".
        if ($not) {
            $allowed = !$allowed;
        }

        return $allowed;
    }

    public function get_description($full, $not, \core_availability\info $info) {
        global $DB;

        if (!$instance = $DB->get_record('certificate', ['id' => $this->certificate_id])) {
            return get_string('certificate_not_found', 'availability_certificate');
        }

        if ($not) {
            return get_string('description_not', 'availability_certificate', ['instance' => $instance->name]);
        } else {
            return get_string('description', 'availability_certificate', ['instance' => $instance->name]);
        }
    }

    protected function get_debug_string() {}

    /**
     *
     *
     * @param int $courseid
     * @return \cm_info[]
     * @throws \moodle_exception
     */
    public static function get_certificate_instances($courseid) {
        $modinfo = get_fast_modinfo($courseid);
        return $modinfo->get_instances_of('certificate');
    }
}