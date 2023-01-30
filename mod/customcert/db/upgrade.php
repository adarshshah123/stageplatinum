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
 * Customcert module upgrade code.
 *
 * @package    mod_customcert
 * @copyright  2016 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Customcert module upgrade code.
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool always true
 */
function xmldb_customcert_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2016120503) {

        $table = new xmldb_table('customcert_templates');
        $field = new xmldb_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'id');
        $dbman->change_field_precision($table, $field);

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2016120503, 'customcert');
    }

    if ($oldversion < 2016120505) {
        $table = new xmldb_table('customcert');
        $field = new xmldb_field('emailstudents', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'requiredtime');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('emailteachers', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'emailstudents');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('emailothers', XMLDB_TYPE_TEXT, null, null, null, null, null, 'emailteachers');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('customcert_issues');
        $field = new xmldb_field('emailed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'code');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2016120505, 'customcert');
    }

    if ($oldversion < 2017050501) {
        // Remove any duplicate rows from customcert issue table.
        // This SQL fetches the id of those records which have duplicate customcert issues.
        // This doesn't return the first issue.
        $fromclause = "FROM (
                             SELECT min(id) AS minid, userid, customcertid
                               FROM {customcert_issues}
                           GROUP BY userid, customcertid
                            ) minid
                       JOIN {customcert_issues} ci
                         ON ci.userid = minid.userid
                        AND ci.customcertid = minid.customcertid
                        AND ci.id > minid.minid";

        // Get the records themselves.
        $getduplicatessql = "SELECT ci.id $fromclause ORDER BY minid";
        if ($records = $DB->get_records_sql($getduplicatessql)) {
            // Delete them.
            $ids = implode(',', array_keys($records));
            $DB->delete_records_select('customcert_issues', "id IN ($ids)");
        }

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2017050501, 'customcert');
    }

    if ($oldversion < 2017050502) {
        // Add column for new 'verifycertificateanyone' setting.
        $table = new xmldb_table('customcert');
        $field = new xmldb_field('verifyany', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0',
            'requiredtime');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2017050502, 'customcert');
    }

    if ($oldversion < 2017050506) {
        $table = new xmldb_table('customcert_elements');
        $field = new xmldb_field('size');

        // Rename column as it is a reserved word in Oracle.
        if ($dbman->field_exists($table, $field)) {
            $field->set_attributes(XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'font');
            $dbman->rename_field($table, $field, 'fontsize');
        }

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2017050506, 'customcert');
    }

    if ($oldversion < 2018051705) {
        $table = new xmldb_table('customcert_elements');
        $field = new xmldb_field('element', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'name');

        // Alter the 'element' column to be characters, rather than text.
        $dbman->change_field_type($table, $field);

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2018051705, 'customcert');
    }

    if ($oldversion < 2019021403) {

        // Define table course_customlang_mapping to be created.
        $table = new xmldb_table('customcert_program_ids');

        // Adding fields to table customcert_program_ids.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('customcertid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('programid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table customcert_program_ids.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('customcertid', XMLDB_KEY_FOREIGN, array('customcertid'), 'customcert', array('id'));

        // Conditionally launch create table for customcert_program_ids.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Savepoint reached.
        upgrade_mod_savepoint(true, 2019021403, 'customcert');
    }

    if ($oldversion < 2019022700) {

        $table = new xmldb_table('customcert_program_ids');
        $field = new xmldb_field('programtime', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'programid');

        // Conditionally launch add field.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
    }

    if ($oldversion < 2019022701) {

        // Define field studentname to be added to customcert_issues.
        $table = new xmldb_table('customcert_issues');
        $field = new xmldb_field('studentname', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'code');

        // Conditionally launch add field studentname.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $existingissues = $DB->get_records('customcert_issues', array('studentname' => null));
        foreach ($existingissues as $issue) {
            if ($user = $DB->get_record('user', array('id' => $issue->userid))) {
                $issue->studentname = $user->firstname . ' ' . $user->lastname;
                $DB->update_record('customcert_issues', $issue);
            }
        }

        // Customcert savepoint reached.
        upgrade_mod_savepoint(true, 2019022701, 'customcert');
    }

    if ($oldversion < 2019022702) {

        // Define table customcert_ctecprogram to be created.
        $table = new xmldb_table('customcert_ctecprogram');

        // Adding fields to table customcert_ctecprogram.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('customcertid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('ctecprogramid', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table customcert_ctecprogram.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('customcert', XMLDB_KEY_FOREIGN, ['customcertid'], 'customcert', ['id']);

        // Conditionally launch create table for customcert_ctecprogram.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Customcert savepoint reached.
        upgrade_mod_savepoint(true, 2019022702, 'customcert');
    }
    
    if ($oldversion < 2019111803) {
        $table = new xmldb_table('customcert');
        $index = new xmldb_index('templateid', XMLDB_INDEX_UNIQUE, ['templateid']);
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }
        $key = new xmldb_key('templateid', XMLDB_KEY_FOREIGN, ['templateid'], 'customcert_templates', ['id']);
        $dbman->add_key($table, $key);

        $table = new xmldb_table('customcert_pages');
        $index = new xmldb_index('templateid', XMLDB_INDEX_UNIQUE, ['templateid']);
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }
        $key = new xmldb_key('templateid', XMLDB_KEY_FOREIGN, ['templateid'], 'customcert_templates', ['id']);
        $dbman->add_key($table, $key);

        upgrade_mod_savepoint(true, 2019111803, 'customcert');
    }

    return true;
}
