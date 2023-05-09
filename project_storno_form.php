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
 *
 * @package mod_projectapproval
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir.'/formslib.php');

class projectstorno_form extends moodleform {

    protected function definition() {
        global $DB;

        $mform =& $this->_form;
        $project = $this->_customdata['project'];
        $cm = get_coursemodule_from_id('projectapproval', $project->cmid);
        $instance = $DB->get_record('projectapproval', array('id' => $cm->instance));

        $mform->addElement('hidden', 'projectid', $project->id);
        $mform->setType('projectid', PARAM_INT);

//        $mform->addElement('header', '', get_string('header_storno_project', 'mod_projectapproval')
//            .' '.$instance->name, 'header_projectapproval');
        $mform->addElement('html', get_string('storno_project', 'mod_projectapproval', $instance->name));

        $this->add_action_buttons(true, get_string('storno', 'mod_projectapproval'));
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        return $errors;
    }
}
