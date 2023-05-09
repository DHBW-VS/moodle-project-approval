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

class projectedit_form extends moodleform {

    protected function definition() {
        global $DB;

        $mform =& $this->_form;
        $project = $this->_customdata['project'];
        $instance = $this->_customdata['instance'];
        $user = $DB->get_record('user', array('id' => $project->userid));

        $mform->addElement('hidden', 'projectid', $project->id);
        $mform->setType('projectid', PARAM_INT);

        //-------------------------------------------------------
        // Show user data part.
        $mform->addElement('header', '', get_string('header_user_data', 'mod_projectapproval'),
            'header_projectapproval');

        $mform->addElement('static', 'username', get_string('name'),
            fullname($user));
        $mform->addElement('static', 'email', get_string('email'),
            $user->email);

        //-------------------------------------------------------
        // Project data part.
        $mform->addElement('header', '', get_string('header_submit_project', 'mod_projectapproval')
            .' '.$instance->name, 'header_projectapproval');

        $mform->addElement('text', 'company', get_string('company', 'mod_projectapproval'),
            array('size' => '48', 'readonly' => true));
        $mform->setType('company', PARAM_RAW);

        $mform->addElement('text', 'company_attendant',
            get_string('company_attendant', 'mod_projectapproval'), array('size' => '48', 'readonly' => true));
        $mform->setType('company_attendant', PARAM_RAW);

        $mform->addElement('text', 'company_email',
            get_string('company_email', 'mod_projectapproval'), array('size' => '48', 'readonly' => true));
        $mform->setType('company_email', PARAM_EMAIL);

        $mform->addElement('text', 'attendant',
            get_string('attendant', 'mod_projectapproval'), array('size' => '48'));
        $mform->setType('attendant', PARAM_RAW);
        $mform->addRule('attendant', null, 'required', null, 'client');

        $mform->addElement('textarea', 'title',
            get_string('title', 'mod_projectapproval'), array('rows' => '2', 'cols' => '48', 'readonly' => true));
        $mform->setType('title', PARAM_RAW);

        $mform->addElement('textarea', 'content',
            get_string('content', 'mod_projectapproval'), array('rows' => '7', 'cols' => '68', 'readonly' => true));
        $mform->setType('content', PARAM_RAW);

        if (!empty($instance->locknote)) {
            if ($project->locknote) {
                $mform->addElement('static', '', get_string('locknote', 'mod_projectapproval'), get_string('yes'));
            } else {
                $mform->addElement('static', '', get_string('locknote', 'mod_projectapproval'), get_string('no'));
            }
        }

        //-------------------------------------------------------
        // Editing part.
        $mform->addElement('header', '', get_string('header_edit_project', 'mod_projectapproval'),
            'header_projectapproval');

        // Comment field.
        $mform->addElement('textarea', 'comment',
            get_string('comment', 'mod_projectapproval'), array('rows' => '7', 'cols' => '68'));
        $mform->setType('comment', PARAM_RAW);

        // Status options.
        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'status', '',
            get_string('open', 'mod_projectapproval'), 'open');
        $radioarray[] = $mform->createElement('radio', 'status', '',
            get_string('accepted', 'mod_projectapproval'), 'accepted');
        $radioarray[] = $mform->createElement('radio', 'status', '',
            get_string('denied', 'mod_projectapproval'), 'denied');
        $radioarray[] = $mform->createElement('radio', 'status', '',
            get_string('callback', 'mod_projectapproval'), 'callback');
        $mform->addGroup($radioarray, 'statusar', '', array(' '), false);
        $mform->addRule('statusar', null, 'required', null, 'client');

        $this->add_action_buttons(true, get_string('edit_button', 'mod_projectapproval'));
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (!empty($data['company_email'])){
            if (! validate_email($data['company_email'])) {
                $errors['company_email'] = get_string('invalidemail');
            }
        }

        return $errors;
    }
}
