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

defined('MOODLE_INTERNAL') || die;

/**
 * Define all the backup steps that will be used by the backup_projectapproval_activity_task
 */

/**
 * Define the complete projectapproval structure for backup, with file and id annotations
 */
class backup_projectapproval_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // Define each element separated
        $projectapproval = new backup_nested_element('projectapproval', array('id'), array(
            'course', 'name', 'intro', 'introformat', 'manager', 'locknote', 'timemodified'));
        $projectapp_project = new backup_nested_element('projectapp_project', array('id'), array(
            'cmid', 'userid', 'company', 'company_attendant', 'company_email', 'attendant', 'title',
            'content', 'comment', 'status', 'locknote', 'timemodified', 'timecreated'));

        // Build the tree
        $projectapproval->add_child($projectapp_project);

        // Define sources
        $projectapproval->set_source_table('projectapproval', array('id' => backup::VAR_ACTIVITYID));
        $projectapp_project->set_source_table('projectapp_project', array('cmid' => backup::VAR_MODID));

        // Define id annotations
        // (none)

        // Define file annotations
        $projectapproval->annotate_files('mod_projectapproval', 'intro', null); // This file areas haven't itemid

        // Return the root element (projectapproval), wrapped into standard activity structure
        return $this->prepare_activity_structure($projectapproval);
    }
}
