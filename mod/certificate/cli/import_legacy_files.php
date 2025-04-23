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
 * Import mod_certificate files from Moodle <= 1.9
 *
 * This script looks for legacy files that match certificate issues in the database.
 * Imported files are added to the Moodle file system.
 *
 * @package    mod_certificate
 * @copyright  MLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');      // cli only functions
require_once($CFG->libdir.'/cronlib.php');

// now get cli options
list($options, $unrecognized) = cli_get_params(array('help'=>false,'moodledata'=>'','verbose'=>false),
    array('h'=>'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help'] || !$options['moodledata']) {
    $help =
        "Import mod_certificate files from Moodle <= 1.9

This script looks for legacy files that match certificate issues in the database.
Imported files are added to the Moodle file system.

Options:
-h, --help            Print out this help
--moodledata          Path to *legacy* Moodle data folder (Moodle <= 1.9)
--verbose             Print summary of each imported file

Example:
\$sudo -u www-data /usr/bin/php mod/certificate/cli/import_legacy_files.php --moodledata=/path/to/legacy/moodledata --verbose=true > results.csv
";

    echo $help;
    die;
}

if (!file_exists($options['moodledata'])) {
    cli_error('Legacy Moodle data does not exist.');
}

if (!is_readable($options['moodledata'])) {
    cli_error('Legacy Moodle data is not readable.');
}

$fs = get_file_storage();

echo 'certificate,certificate_id,course,course_id,user_id,issue_id,file_name';

foreach ($DB->get_recordset('certificate_issues') as $issue) {
    if (!$certificate = $DB->get_record('certificate', ['id' => $issue->certificateid])) {
        continue;
    }

    if (!$course = $DB->get_record('course', ['id' => $certificate->course])) {
        continue;
    }

    $folder_path = sprintf('%s/%s/moddata/certificate/%s/%s', $options['moodledata'], $course->id, $certificate->id, $issue->userid);

    if (!file_exists($folder_path)) {
        continue;
    }

    $cm = get_coursemodule_from_instance('certificate', $certificate->id);
    $context = \context_module::instance($cm->id);

    $di = new RecursiveDirectoryIterator($folder_path);
    foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
        if (in_array($file->getFilename(), ['.', '..'])) continue;
        if (is_file($filename)) {
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            if ($filetype == 'pdf') {

                $fileinfo = [
                    'contextid' => $context->id,
                    'component' => 'mod_certificate',
                    'filearea' => 'issue',
                    'itemid' => $issue->id,
                    'filepath' => '/',
                    'filename' => $file->getFilename()];

                if (!$fs->file_exists($context->id, 'mod_certificate', 'issue', $issue->id, '/', $file->getFilename())) {
                    $fs->create_file_from_pathname($fileinfo, $filename);

                    if ($options['verbose']) {
                        echo implode(',', [$certificate->name, $certificate->id, $course->fullname, $course->id, $issue->userid, $issue->id, $file->getFilename()]);
                    }
                }
            }
        }
    }
}