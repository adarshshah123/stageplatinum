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
 * Form for editing Earned Certificates block instances.
 *
 * @package   block_earned_certificates
 * @copyright 2019 MLC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_earned_certificates extends block_list {

    /**
     * Default certificates to display per page for pagination bar.
     */
    const DEFAULT_PER_PAGE = 5;

    function init() {
        $this->title = get_string('pluginname', 'block_earned_certificates');
    }

    function has_config() {
        return true;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    function applicable_formats() {
        return array('all' => true);
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER, $PAGE;

        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== NULL) {
            // @codeCoverageIgnoreStart
            return $this->content;
            // @codeCoverageIgnoreEnd
        }

        $page = optional_param('cpage', 0, PARAM_INT);
        $selectedyear = optional_param('issue_year', null, PARAM_TEXT);

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $this->content->items = [];
        $this->content->icons = [];

        if (!isloggedin() || isguestuser()) {
            return $this->content;
        }

        $customissues = array_values(self::get_customcert_issues($USER->id));
        $certificateissues = array_merge(self::get_certificate_issues($USER->id));
        $issues = array_merge($customissues, $certificateissues);

        // Get list of available years from issues.
        $years = [];
        foreach ($issues as $issue) {
            $dateissued = new \DateTime('@' . $issue->timecreated, \core_date::get_user_timezone_object());
            $years[$dateissued->format('Y')] = $dateissued->format('Y');
        }
        ksort($years);

        $url = $PAGE->url;
        $url->set_anchor('inst' . $this->instance->id);
        $this->content->text .= $OUTPUT->single_select($url, 'issue_year', $years, $selectedyear);

        if (isset($this->config->perpage) && $this->config->perpage > 0) {
            $perpage = $this->config->perpage;
        } else {
            $perpage = self::DEFAULT_PER_PAGE;
        }

        // Filter out certificates.
        if ($selectedyear) {
            foreach ($issues as $key => $issue) {
                $dateissued = new \DateTime('@' . $issue->timecreated, \core_date::get_user_timezone_object());
                if ($dateissued->format('Y') != $selectedyear) {
                    unset($issues[$key]);
                }
            }
        }

        $url = $PAGE->url;
        $url->set_anchor('inst' . $this->instance->id);
        $url->param('issue_year', $selectedyear);
        $this->content->footer .= $OUTPUT->paging_bar(count($issues), $page, $perpage, $url, 'cpage');

        // Paginate certificates.
        $issues = array_slice(array_values($issues), $page * $perpage, $perpage);
        foreach ($issues as $issue) {
            if ($issue->timecreated) {
                $issue->issueddate = (new \DateTime('@' . $issue->timecreated, \core_date::get_user_timezone_object()))->format('Y-m-d');
            }
            $this->content->items[] = $OUTPUT->render_from_template('block_earned_certificates/certificate_item', $issue);
        }

        return $this->content;
    }

    /**
     * Convert the contents of the block to HTML.
     *
     * This is used by block base classes like block_list to convert the structured
     * $this->content->list and $this->content->icons arrays to HTML. So, in most
     * blocks, you probaby want to override the {@link get_contents()} method,
     * which generates that structured representation of the contents.
     *
     * @param $output The core_renderer to use when generating the output.
     * @return string the HTML that should appearn in the body of the block.
     * @since Moodle 2.0.
     */
    protected function formatted_contents($output) {
        $this->get_content();
        $this->get_required_javascript();
        if (!empty($this->content->items)) {
            $content = '';
            if (isset($this->content->text) && !empty($this->content->text)) {
                $content .= $this->content->text;
            }
            $content .= $output->list_block_contents($this->content->icons, $this->content->items);
            return $content;
        } else {
            return '';
        }
    }

    /**
     * Get all certificate issues with file links for a specific user.
     *
     * @param int $userid
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public static function get_certificate_issues($userid)
    {
        global $DB;

        $pluginmanager = core_plugin_manager::instance();

        if (array_key_exists('certificate', $pluginmanager->get_installed_plugins('mod'))) {
            $sql = "SELECT i.*, cert.id AS instance, cert.name, c.fullname AS course_fullname, 'certificate' AS modtype
                    FROM {certificate_issues} i
                    JOIN {certificate} AS cert ON cert.id = i.certificateid
                    JOIN {course} AS c ON c.id = cert.course
                    AND userid = :userid
                    ORDER BY i.timecreated DESC";

            if ($issues = $DB->get_records_sql($sql, ['userid' => $userid])) {

                foreach ($issues as $key => $issue) {
                    $cm = get_coursemodule_from_instance($issue->modtype, $issue->instance);
                    $context = context_module::instance($cm->id);

                    $fs = get_file_storage();
                    if (!$files = $fs->get_area_files($context->id, 'mod_certificate', 'issue', $issue->id)) {
                        // Remove certificate issue if PDF no longer exists.
                        unset($issues[$key]);
                    }
                    $issue->files = [];
                    foreach ($files as $file) {
                        if ($file->is_directory()) continue;

                        $link = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename(), true);

                        $issue->files[] = [
                            'file' => $file,
                            'filename' => s($file->get_filename()),
                            'link' => $link
                        ];
                    }
                }

                return array_values($issues);
            }
        }

        return [];
    }

    /**
     * Get all customcert issues with file links for a specific user.
     *
     * @param $userid
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public static function get_customcert_issues($userid)
    {
        global $DB;

        $pluginmanager = core_plugin_manager::instance();

        if (array_key_exists('customcert', $pluginmanager->get_installed_plugins('mod'))) {
            $sql = "SELECT i.*, cert.id AS instance, cert.name, c.fullname AS course_fullname, 'customcert' AS modtype
                    FROM {customcert_issues} i
                    JOIN {customcert} AS cert ON cert.id = i.customcertid
                    JOIN {course} AS c ON c.id = cert.course
                    AND userid = :userid
                    ORDER BY i.timecreated DESC";

            if ($issues = $DB->get_records_sql($sql, ['userid' => $userid])) {

                foreach ($issues as $issue) {
                    $cm = get_coursemodule_from_instance($issue->modtype, $issue->instance);

                    $issue->files = [];
                    $issue->files[] = [
                        'filename' => $issue->name,
                        'link' => new moodle_url('/mod/customcert/view.php', ['id' => $cm->id, 'downloadissue' => $userid])
                    ];
                }

                return array_values($issues);
            }
        }

        return [];
    }
}
