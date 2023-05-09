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
 * @copyright 2022 eLeDia GmbH {@link http://www.eledia.de}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

use mod_projectapproval\util;
global $FULLME, $PAGE, $DB, $CFG, $OUTPUT, $USER;

require_once('locallib.php');
require_once('project_edit_form.php');

$projectid = required_param('projectid', PARAM_INT);
$project = $DB->get_record('projectapp_project', array('id' => $projectid));

$cm = get_coursemodule_from_id('projectapproval', $project->cmid);
$instance = $DB->get_record('projectapproval', array('id' => $cm->instance));

require_login();
require_capability('mod/projectapproval:manage_submissions', context_module::instance($cm->id));

$myurl = new moodle_url($FULLME);

$PAGE->set_url($myurl);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('course');

$mform = new projectedit_form(null,
    array('cm' => $cm, 'instance' => $instance, 'project' => $project));
$mform->set_data($project);
$modlink = $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id;

$util = new util();

if ($mform->is_cancelled()) {
    redirect($modlink);
}

if ($formdata = $mform->get_data()) {

    // Save edit submission.
    $util->save_edit_project($formdata);

    // Email to student.
    $supportuser = core_user::get_support_user();
    $data = new stdClass();
    $data->instancename = $instance->name;
    $data->modlink = $modlink;
    $student = $DB->get_record('user', array('id' => $project->userid));
    $data->fullname = fullname($student);
    $data->project_title = $project->title;

    switch ($formdata->status) {
        case 'accepted':
            $subject     = get_string('email_accepted_subject', 'mod_projectapproval', $data);
            $message     = get_string('email_accepted_message', 'mod_projectapproval', $data);
            $messagehtml = text_to_html(get_string('email_accepted_message', 'mod_projectapproval',
                $data), false, false);
            break;
        case 'denied':
            $subject     = get_string('email_denied_subject', 'mod_projectapproval', $data);
            $message     = get_string('email_denied_message', 'mod_projectapproval', $data);
            $messagehtml = text_to_html(get_string('email_denied_message', 'mod_projectapproval',
                $data), false, false);
            break;
        case 'callback':
            $subject     = get_string('email_callback_subject', 'mod_projectapproval', $data);
            $message     = get_string('email_callback_message', 'mod_projectapproval', $data);
            $messagehtml = text_to_html(get_string('email_callback_message', 'mod_projectapproval',
                $data), false, false);
            break;
        default:
            // Return to view page without email if status open.
            redirect($modlink);
    }

    $student->mailformat = 1;  // Always send HTML version as well.
    email_to_user($student, $supportuser, $subject, $message, $messagehtml);

    // Return to view page after edit.
    redirect($modlink);
}

$cm_link = '<a href="'.$modlink.'" >'.$instance->name.'</a>';
$PAGE->navbar->add($cm_link);
$header = get_string('header_submit_project', 'mod_projectapproval').' '.$instance->name;
$PAGE->set_heading($header);
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
