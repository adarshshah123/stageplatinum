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
 * Version info.
 *
 * @package availability_certificate
 * @copyright 2019 My Learning Consultants
 * @author Joseph Conradt
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure.
 *
 * Programmatically add availability_certificate to mod_certificate instances.
 */
function xmldb_availability_certificate_install() {
    global $DB;

    set_config('enableavailability', 1);

    if (!$module_id = $DB->get_field('modules', 'id', ['name' => 'certificate'])) {
        return;
    }

    $records = $DB->get_records('course_modules', ['module' => $module_id]);

    foreach ($records as $record) {
        if (!$availability = json_decode($record->availability)) {
            // Add JSON structure if module has no preexisting availability conditions.
            $availability = (object)[
                'op' => \core_availability\tree::OP_AND,
                'c' => [],
                'showc' => []
            ];
        }

        // Check if the availability_certificate condition has been added already. Unlikely but checking just in case.
        $has_certificate = false;
        foreach ($availability->c as $condition) {
            if ($condition->type == 'certificate') {
                $has_certificate = true;
                break;
            }
        }

        if (!$has_certificate) {
            // Add the availability condition to this module and update it.
            $availability->c[] = (object)[
                'type' => 'certificate',
                'certificate_id' => $record->instance
            ];
            // mod_certificate instances should be hidden when restricted.
            $availability->showc[] = false;

            $record->availability = json_encode($availability);
            $DB->update_record('course_modules', $record);
        }
    }
}
