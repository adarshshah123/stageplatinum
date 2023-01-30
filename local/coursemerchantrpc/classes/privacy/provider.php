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
 * Data provider.
 *
 * @package    local_coursemerchant
 * @copyright  2018 
 * @author     Course Merchant http://www.coursemerchant.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_coursemerchant\privacy;
defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;

require_once($CFG->libdir . '/badgeslib.php');

/**
 * Data provider class.
 *
 * @package    core_badges
 * @copyright  2018 Frédéric Massart
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\subsystem\provider {

    /**
     * Returns metadata.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection {

	// Course Merchant recieves a copy of profile data
        $collection->add_external_location_link('coursemerchant', [
            'name' => 'privacy:metadata:external:coursemerchant:name',
            'description' => 'privacy:metadata:external:coursemerchant:description',
            'username' => 'privacy:metadata:external:coursemerchant:username',
            'profile' => 'privacy:metadata:external:coursemerchant:profile',
            'enrolments' => 'privacy:metadata:external:coursemerchant:enrolments',
	    'categories' => 'privacy:metadata:external:coursemerchant:categories',
        ], 'privacy:metadata:external:coursemerchant');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     * @param int $userid The user to search.
     * @return contextlist $contextlist The contextlist containing the list of contexts used in this plugin.
     **/
    public static function get_contexts_for_userid(int $userid) : \core_privacy\local\request\contextlist {
        $contextlist = new \core_privacy\local\request\contextlist();
        return $contextlist;
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     **/
    public static function export_user_data(approved_contextlist $contextlist) {
	// Course Merchant only updates information in existing Moodle core tables
    }

    /**
     * Delete all data for all users in the specified context.
     * @param context $context The specific context to delete data for.
     **/
    public static function delete_data_for_all_users_in_context(context $context) {
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     **/
    public static function delete_data_for_user(approved_contextlist $contextlist) {
    }

    /**
     * Delete all the data for a user.
     * @param int $userid The user ID.
     * @return void
     **/
    protected static function delete_user_data($userid) {
    }

}
