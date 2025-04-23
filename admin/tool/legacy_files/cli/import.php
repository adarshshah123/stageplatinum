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
 * Import legacy files from Moodle <= 1.9 (Only tested on 1.9)
 *
 * Imported files are added to the Moodle file system.
 *
 * @package    tool_legacy_files
 * @copyright  MLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../../../../config.php');
require_once($CFG->libdir.'/clilib.php');      // cli only functions

global $DB;

// now get cli options
list($options, $unrecognized) = cli_get_params(array('help'=>false,'moodledata'=>'','force'=>false),
    array('h'=>'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help'] || !$options['moodledata']) {
    $help =
        "Import legacy files from Moodle <= 1.9 (Only tested on 1.9)

Imported files are added to the Moodle file system.

IMPORTANT: RUN SCRIPT AS PHP/WEB SERVER USER, NOT ROOT!

MAKE SURE SOURCE DATA FOLDER IS OWNED BY USER RUNNING SCRIPT

Options:
-h, --help            Print out this help
--moodledata          Path to *legacy* Moodle data folder (Moodle <= 1.9)
--force               Skip permission checks (not recommended)

Example:
\$sudo -u www-data /usr/bin/php admin/tool/legacy_files/cli/import.php --moodledata=/path/to/legacy/moodledata
";

    echo $help;
    die;
}

if (!file_exists($options['moodledata'])) {
    echo('Legacy Moodle data does not exist.');die;
}

if (!is_readable($options['moodledata'])) {
    echo('Legacy Moodle data is not readable.');die;
}

if (!$options['force']) {
    $user = exec('whoami');
    $iterator = new DirectoryIterator(dirname($CFG->dataroot));
    $dataowner = posix_getpwuid($iterator->getOwner());
    if ($user != $dataowner['name']) {
        echo('Run script as the user who owns Moodle data folder (' . $dataowner['name'] . ') to keep permissions consistent. Otherwise run with --force=true (not recommended).');die;
    }
}


$fs = get_file_storage();

$it = new RecursiveDirectoryIterator($options['moodledata']);

/** @var SplFileInfo $file */
foreach(new RecursiveIteratorIterator($it) as $file) {
    if ($file->isFile()) {
        $hash = sha1_file($file->getPathname());

        foreach ($DB->get_records('files', ['contenthash' => $hash]) as $record) {
            $storedfile = $fs->get_file_by_id($record->id);
            if ($storedfile->is_directory()) continue;
            $storedfile->delete();
            $fs->create_file_from_pathname($record, $file->getPathname());
        }
    }
}
