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
 * projectapproval configuration form
 *
 * @package mod_projectapproval
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
global $CFG, $DB, $COURSE;
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/projectapproval/locallib.php');
require_once($CFG->libdir.'/filelib.php');

class mod_projectapproval_mod_form extends moodleform_mod {
    function definition() {
        global $CFG, $DB, $COURSE;

        $mform = $this->_form;

        $courseid = optional_param('course', $COURSE->id, PARAM_RAW);

        //-------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size'=>'48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $this->standard_intro_elements();

        //-------------------------------------------------------
        $course_manager = array();
        $course_manager[0] = get_string('choose');
        $context = context_course::instance($courseid);
        $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $user_assignmenents = get_users_from_role_on_context($role, $context);
        if (!empty($user_assignmenents)) {
            foreach ($user_assignmenents as $user_assignmenent) {
                $user =  $DB->get_record('user', array('id' => $user_assignmenent->userid));
                $course_manager[$user_assignmenent->userid] = $user->firstname.' '.$user->lastname;
            }
        }
        $mform->addElement('select', 'manager', get_string('manager', 'projectapproval'), $course_manager);
        $mform->addRule('manager', null, 'required', null, 'client');
        $mform->setType('manager', PARAM_RAW);

        $mform->addElement('advcheckbox', 'locknote', '',
            get_string('locknote_use', 'mod_projectapproval'), array('group' => 1), array(0, 1));

        //-------------------------------------------------------
        $this->standard_coursemodule_elements();

        //-------------------------------------------------------
        $this->add_action_buttons();
    }

    public function validation($data, $files) {

        $errors = parent::validation($data, $files);
        if ($data['manager'] == 0) {
            $errors['manager'] = get_string('missingteacher');
        }

        return $errors;
    }

    /**
     * Enforce defaults here.
     *
     * @param array $defaultvalues Form defaults
     * @return void
     **/
    public function data_preprocessing(&$defaultvalues) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('projectapproval');
            $defaultvalues['projectapproval']['itemid'] = $draftitemid;
        }
    }
}

