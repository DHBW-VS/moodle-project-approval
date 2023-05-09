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
 * @package   mod_projectapproval
 * @category  backup
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the restore steps that will be used by the restore_projectapproval_activity_task
 */

/**
 * Structure step to restore one projectapproval activity
 */
class restore_projectapproval_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {
        $paths = array();
        $paths[] = new restore_path_element('projectapproval', '/activity/projectapproval');
        $paths[] = new restore_path_element('projectapp_project', '/activity/projectapproval/projectapp_project');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_projectapproval($data) {
        global $DB;

        $data = (object)$data;
        $data->course = $this->get_courseid();

        // Insert the projectapproval record.
        $newitemid = $DB->insert_record('projectapproval', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    protected function process_projectapp_project($data) {
        global $DB;

        // To know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');
        if (!$userinfo) {
            retrun;
        }
        $data = (object)$data;
        // Set new cmid.
        $data->cmid = $this->task->get_moduleid();
        if (!$this->task->is_samesite()) {
            // Set new userid.
            $data->userid = $this->get_mappingid('user', $data->userid);
        }

        // Insert the projectapp_project record.
        $newitemid = $DB->insert_record('projectapp_project', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add projectapproval related files, no need to match by itemname (just internally handled context).
        $this->add_related_files('mod_projectapproval', 'intro', null);
    }
}
