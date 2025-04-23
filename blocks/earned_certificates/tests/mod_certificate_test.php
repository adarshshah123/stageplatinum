<?php

// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   block_earned_certificates
 * @copyright 2019 MLC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * @group mlc
 * @group block_earned_certificate
 */
class mod_certificate_testcase extends advanced_testcase
{
    private $user;
    private $course;
    private $certificate;
    private $certificate_cm;
    private $customcert;
    private $pluginmanager;

    public function setUp()
    {
        global $DB;
        parent::setUp();

        $this->pluginmanager = core_plugin_manager::instance();

        $this->user = $this->getDataGenerator()->create_user();
        $this->course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($this->user->id, $this->course->id);

        if (array_key_exists('certificate', $this->pluginmanager->get_installed_plugins('mod'))) {
            $this->certificate = $this->getDataGenerator()->create_module('certificate', [
                'course' => $this->course->id,
                'savecert' => true
            ]);
            $this->certificate_cm = $DB->get_record('course_modules', ['id' => $this->certificate->cmid]);
        }
        if (array_key_exists('customcert', $this->pluginmanager->get_installed_plugins('mod'))) {
            $this->customcert = $this->getDataGenerator()->create_module('customcert', [
                'course' => $this->course->id,
                'programids' => [],
                'programtime' => []
            ]);
        }
    }

    public function test_issued_certificates()
    {
        global $CFG, $DB, $USER;

        require_once("$CFG->dirroot/blocks/earned_certificates/block_earned_certificates.php");
        require_once("$CFG->libdir/pdflib.php");

        $this->resetAfterTest();

        $pluginmanager = core_plugin_manager::instance();

        $plugins = $pluginmanager->get_installed_plugins('mod');

        if (array_key_exists('certificate', $plugins)) {
            require_once("$CFG->dirroot/mod/certificate/locallib.php");

            $certrecord = certificate_get_issue($this->course, $this->user, $this->certificate, $this->certificate_cm);
            $certificate = $this->certificate;
            $course = $this->course;

            make_cache_directory('tcpdf');

            // Load the specific certificate type.
            require("$CFG->dirroot/mod/certificate/type/".$this->certificate->certificatetype."/certificate.php");

            $filename = certificate_get_certificate_filename($this->certificate, $this->certificate_cm, $this->course) . '.pdf';

            // PDF contents are now in $file_contents as a string.
            $filecontents = $pdf->Output('', 'S');

            if ($this->certificate->savecert == 1) {
                certificate_save_pdf($filecontents, $certrecord->id, $filename, context_module::instance($this->certificate_cm->id)->id);
            }

            $issues = block_earned_certificates::get_certificate_issues($this->user->id);
            $this->assertCount(1, $issues, 'Ensure issued certificate is found.');
            $this->assertCount(1, $issues[0]->files, 'Ensure only one file is returned.');
            $this->assertEquals('tc_1_Certificate 1.pdf', $issues[0]->files[0]['filename'], 'Ensure filename is correct.');
            $this->assertNotEmpty($issues[0]->files[0]['file']->get_content(), 'Ensure file has contents.');

            self::unenroll($this->user->id, $this->course->id);

            $issues = block_earned_certificates::get_certificate_issues($this->user->id);

            $this->assertCount(1, $issues, 'Ensure issued certificate is found despite no enrollment.');

            $DB->execute('UPDATE {course} SET visible = 0 WHERE id = :id', ['id' => $this->course->id]);

            $issues = block_earned_certificates::get_certificate_issues($this->user->id);
            $this->assertCount(1, $issues, 'Ensure issued certificate is still returned from disabled course.');
        }
    }

    public function test_issued_customcerts()
    {
        global $CFG, $DB;

        $this->resetAfterTest();

        $pluginmanager = core_plugin_manager::instance();

        $plugins = $pluginmanager->get_installed_plugins('mod');

        if (array_key_exists('customcert', $plugins)) {

            \mod_customcert\certificate::issue_certificate($this->customcert->id, $this->user->id);

            $issues = block_earned_certificates::get_customcert_issues($this->user->id);
            $this->assertCount(1, $issues, 'Ensure issued certificate is found.');
            $this->assertCount(1, $issues[0]->files, 'Ensure only one file is returned.');
            $this->assertEquals('Custom certificate 1', $issues[0]->files[0]['filename'], 'Ensure filename is correct.');

            self::unenroll($this->user->id, $this->course->id);

            $issues = block_earned_certificates::get_customcert_issues($this->user->id);

            $this->assertCount(1, $issues, 'Ensure issued certificate is found despite no enrollment.');

            $DB->execute('UPDATE {course} SET visible = 0 WHERE id = :id', ['id' => $this->course->id]);

            $issues = block_earned_certificates::get_customcert_issues($this->user->id);
            $this->assertCount(1, $issues, 'Ensure issued certificate is still returned from disabled course.');
        }
    }

    public function test_get_block_content()
    {
        global $CFG;

        $this->resetAfterTest();

        $issue = certificate_get_issue($this->course, $this->user, $this->certificate, $this->certificate_cm);
        if ($this->certificate->savecert == 1) {
            certificate_save_pdf('test', $issue->id, 'test.pdf', context_module::instance($this->certificate_cm->id)->id);
        }
        \mod_customcert\certificate::issue_certificate($this->customcert->id, $this->user->id);

        require_once("$CFG->dirroot/blocks/earned_certificates/block_earned_certificates.php");

        $block = new block_earned_certificates();
        $content = $block->get_content();

        $this->assertCount(0, $content->items, 'Ensure block is empty when not logged in.');

        $this->setUser($this->user);

        $block = new block_earned_certificates();
        $content = $block->get_content();

        $this->assertCount(2, $content->items, 'Ensure both certificate and customcert issues are outputted');
    }

    public function test_lost_pdf()
    {
        global $CFG, $DB, $USER;

        require_once("$CFG->dirroot/blocks/earned_certificates/block_earned_certificates.php");
        require_once("$CFG->libdir/pdflib.php");

        $this->resetAfterTest();

        $pluginmanager = core_plugin_manager::instance();

        $plugins = $pluginmanager->get_installed_plugins('mod');

        if (array_key_exists('certificate', $plugins)) {
            require_once("$CFG->dirroot/mod/certificate/locallib.php");

            $certrecord = certificate_get_issue($this->course, $this->user, $this->certificate, $this->certificate_cm);
            $certificate = $this->certificate;
            $course = $this->course;

            make_cache_directory('tcpdf');

            // Load the specific certificate type.
            require("$CFG->dirroot/mod/certificate/type/".$this->certificate->certificatetype."/certificate.php");

            $filename = certificate_get_certificate_filename($this->certificate, $this->certificate_cm, $this->course) . '.pdf';

            // PDF contents are now in $file_contents as a string.
            $filecontents = $pdf->Output('', 'S');

            $issues = block_earned_certificates::get_certificate_issues($this->user->id);
            $this->assertCount(0, $issues, 'Ensure issued certificate is not found, since it was never saved as PDF.');
        }
    }

    private static function unenroll($userid, $courseid)
    {
        global $DB;

        $enrol_plugin = enrol_get_plugin('manual');
        $instances = $DB->get_records('enrol', ['courseid' => $courseid, 'enrol' => 'manual']);
        $instance = reset($instances);
        $enrol_plugin->unenrol_user($instance, $userid);
    }
}
