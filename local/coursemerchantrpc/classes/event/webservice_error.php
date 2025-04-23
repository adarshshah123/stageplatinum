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
 * The EVENTNAME event.
 *
 * @package    coursemerchantrpc
 * @copyright  2016 Connected Shopping Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_coursemerchantrpc\event;
defined('MOODLE_INTERNAL') || die();

/**
 * Web service error event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string reason: failure reason.
 * }
 *
 * @package    local_coursemerchantrpc
 * @since      Moodle 2.6
 * @copyright  2016 Connected Shopping Ltd.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class webservice_error extends \core\event\base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "Course Merchant Webservice Failed with reason: \"{$this->other['reason']}\".";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return "Course Merchant Local RPC Module";
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->context = \context_system::instance();
    }

    public static function get_other_mapping() {
        return false;
    }
}
