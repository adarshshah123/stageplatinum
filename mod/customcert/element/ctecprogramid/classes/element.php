<?php
// This file is part of the customcert module for Moodle - http://moodle.org/
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
 * This file contains the customcert element program id core interaction API.
 *
 * @package    customcertelement_programid
 * @copyright  2019 MLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace customcertelement_ctecprogramid;

defined('MOODLE_INTERNAL') || die();

/**
 * The customcert element ctecprogramid core interaction API.
 *
 * @package    customcertelement_ctecprogramid
 * @copyright  2019 MLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class element extends \mod_customcert\element {

    /**
     * Handles rendering the element on the pdf.
     *
     * @param \pdf $pdf the pdf object
     * @param bool $preview true if it is a preview, false otherwise
     * @param \stdClass $user the user we are rendering this for
     */
    public function render($pdf, $preview, $user) {
        \mod_customcert\element_helper::render_content($pdf, $this, $this->get_program_id());
    }

    /**
     * Render the element in html.
     *
     * This function is used to render the element when we are using the
     * drag and drop interface to position it.
     *
     * @return string the html
     */
    public function render_html() {
        return \mod_customcert\element_helper::render_html_content($this, $this->get_program_id());
    }

    /**
     * Helper function that returns the ctecprogramid.
     *
     * @return string
     */
    protected function get_program_id() : string {
        global $DB;

        $context = \mod_customcert\element_helper::get_context($this->get_id());
        $courseid = \mod_customcert\element_helper::get_courseid($this->get_id());
        $modinfo = get_fast_modinfo($courseid);
        $cm = $modinfo->get_cm($context->instanceid);
        $programs = $DB->get_records('customcert_ctecprogram', ['customcertid' => $cm->instance]);
        $programlist = implode(', ',
            array_map( function($x) { if (!empty($x->ctecprogramid)) {
                return $x->ctecprogramid ;
            } }, $programs));

        return format_string($programlist, true, ['context' => $context]);
    }
}
