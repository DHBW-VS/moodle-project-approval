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

class projectsubmit_form extends moodleform {

    protected function definition() {
        global $DB;

        $mform =& $this->_form;
        $cm = $this->_customdata['cm'];

        $instance = $DB->get_record('projectapproval', array('id' => $cm->instance));

        $mform->addElement('hidden', 'cm', $cm->id);
        $mform->setType('cm', PARAM_INT);

        $mform->addElement('header', '', get_string('header_submit_project', 'mod_projectapproval')
            .' '.$instance->name, 'header_projectapproval');

        $mform->addElement('text', 'company', get_string('company', 'mod_projectapproval'), array('size' => '48'));
        $mform->setType('company', PARAM_RAW);
        $mform->addRule('company', null, 'required', null, 'client');

        $mform->addElement('text', 'company_attendant',
            get_string('company_attendant', 'mod_projectapproval'), array('size' => '48'));
        $mform->setType('company_attendant', PARAM_RAW);

        $mform->addElement('text', 'company_email',
            get_string('company_email', 'mod_projectapproval'), array('size' => '48'));
        $mform->setType('company_email', PARAM_EMAIL);

        $mform->addElement('text', 'attendant',
            get_string('attendant', 'mod_projectapproval'), array('size' => '48'));
        $mform->setType('attendant', PARAM_RAW);

        $mform->addElement('textarea', 'title',
            get_string('title', 'mod_projectapproval'), array('rows' => '2', 'cols' => '48'));
        $mform->setType('title', PARAM_RAW);
        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('textarea', 'content',
            get_string('content', 'mod_projectapproval'), array('rows' => '7', 'cols' => '68'));
        $mform->setType('content', PARAM_RAW);
        $mform->addRule('content', null, 'required', null, 'client');

        // Locknote.
        if (!empty($instance->locknote)) {
            $mform->addElement('advcheckbox', 'locknote', '',
                get_string('locknote', 'mod_projectapproval'), array('group' => 1), array(0, 1));
        }

        $this->add_action_buttons(true, get_string('submit', 'mod_projectapproval'));
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
