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
 * Privacy Subsystem implementation for mod_projectapproval.
 *
 * @package    mod_projectapproval
 * @copyright  2022 eLeDia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_projectapproval\privacy;

defined('MOODLE_INTERNAL') || die();

use \context;
use \core_privacy\local\request\approved_contextlist;
use \core_privacy\local\request\writer;
use \core_privacy\local\metadata\collection;
use \core_privacy\local\request\userlist;
use \core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\deletion_criteria;
use core_privacy\local\request\helper;


/**
 * Privacy Subsystem implementation for mod_projectapproval.
 *
 * @copyright  2019 eLeDia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    // The mod_projectapproval stores user provided data.
    \core_privacy\local\metadata\provider,
    // The mod_projectapproval provides data directly to core.
    \core_privacy\local\request\plugin\provider,
    // The mod_projectapproval is capable of determining which users have data within it.
    \core_privacy\local\request\core_userlist_provider {

    /**
     * Returns information about how mod_projectapproval stores its data.
     *
     * @param collection $collection The initialised collection to add items to.
     *
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {

        $collection->add_database_table('projectapp_project', [
            'cmid' => 'privacy:metadata:database:projectapp_project:cmid',
            'userid' => 'privacy:metadata:database:projectapp_project:userid',
            'company' => 'privacy:metadata:database:projectapp_project:company',
            'company_attendant' => 'privacy:metadata:database:projectapp_project:company_attendant',
            'company_email' => 'privacy:metadata:database:projectapp_project:company_email',
            'attendant' => 'privacy:metadata:database:projectapp_project:attendant',
            'title' => 'privacy:metadata:database:projectapp_project:title',
            'content' => 'privacy:metadata:database:projectapp_project:content',
            'comment' => 'privacy:metadata:database:projectapp_project:comment',
            'status' => 'privacy:metadata:database:projectapp_project:status',
            'locknote' => 'privacy:metadata:database:projectapp_project:locknote',
            'policy' => 'privacy:metadata:database:projectapp_project:policy',
            'timecreated' => 'privacy:metadata:database:projectapp_project:timecreated',
            'timemodified' => 'privacy:metadata:database:projectapp_project:timemodified',
        ], 'privacy:metadata:database:projectapp_project');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist $contextlist The contextlist containing the list of contexts used in
     *                                                  this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {

        // Fetch all projects.
        $sql = "SELECT c.id
                  FROM {context} c
            INNER JOIN {course_modules} cm ON cm.id = c.instanceid AND c.contextlevel = :contextlevel
            INNER JOIN {modules} m ON m.id = cm.module AND m.name = :modname
            INNER JOIN {projectapproval} proj ON proj.id = cm.instance
            INNER JOIN {projectapp_project} subs ON subs.cmid = cm.id
                 WHERE subs.userid = :userid";

        $params = [
            'modname' => 'projectapproval',
            'contextlevel' => CONTEXT_MODULE,
            'userid' => $userid,
        ];
        $contextlist = new contextlist();
        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users within a specific context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context/plugin combination.
     * @throws \dml_exception
     */
    public static function get_users_in_context(userlist $userlist) {
        global $DB;
        $context = $userlist->get_context();
        if (!$context instanceof \context_module) {
            return;
        }

        // Fetch all users who have a project.
        $sql = "SELECT projects.userid
                  FROM {projectapp_project} projects
                 WHERE cm.id = :cmid";
        $params = [
            'cmid'      => $context->instanceid
        ];
        $userlist->add_from_sql('userid', $sql, $params);
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }
        $user = $contextlist->get_user();

        // Get user records for table mod_projectapproval_table.
        $userdata = $DB->get_records('projectapp_project', array('userid' => $user->id));
        foreach ($userdata as $data) {
            unset($data->id);// Dont export the moodle internal id.
            $context = \context_module::instance($data->cmid);
            $contextdata = (object) array_merge((array) $context, (array) $data);
            writer::with_context($context)->export_data([], $contextdata);//$data $subcontext
            // Write module intro files.
            helper::export_context_files($context, $user);
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param   context $context The specific context to delete data for.
     *
     * @throws \dml_exception
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if (!$context instanceof \context_user) {
            return;
        }

        $user = $DB->get_record('user', array('id' => $context->instanceid));
        $DB->delete_records('projectapp_project', array('userid' => $user->id));
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $userids = $userlist->get_userids();

        foreach ($userids as $userid) {
            $user = $DB->get_record('user', array('id' => $userid));
            $DB->delete_records('projectapp_project', array('userid' => $user->id));
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist $contextlist The approved contexts and user information to delete information for.
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $user = $contextlist->get_user();
        $DB->delete_records('projectapp_project', array('userid' => $user->id));
    }
}
