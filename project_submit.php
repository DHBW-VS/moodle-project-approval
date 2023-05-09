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
require_once('project_submit_form.php');

$cmid = required_param('cm', PARAM_INT);

require_login();
require_capability('mod/projectapproval:view', context_module::instance($cmid));

$myurl = new moodle_url($FULLME);

$PAGE->set_url($myurl);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('course');

$cm = get_coursemodule_from_id('projectapproval', $cmid);
$instance = $DB->get_record('projectapproval', array('id' => $cm->instance));
$mform = new projectsubmit_form(null, array('cm' => $cm, 'instance' => $instance));
$util = new util();

// Load data when project exists.
$project = $DB->get_record('projectapp_project', array('cmid' => $cmid, 'userid' => $USER->id));
if ($project) {
    if ($project->status == 'callback' ) {
        // Only load data on callback. Prevent old data wehn previous try was denied.
        $mform->set_data($project);
    }
}

if ($mform->is_cancelled()) {
    redirect($CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cmid);
}

if ($formdata = $mform->get_data()) {
    // Save the new submission.
    $projectid = $util->save_new_project($formdata);

    // Email to manager.
    $supportuser = core_user::get_support_user();
    $data = new stdClass();
    $data->instancename = $instance->name;
    $data->modlink = $CFG->httpswwwroot.'/mod/projectapproval/project_edit.php?projectid='.$projectid;
    if (!empty($project)) {
        $user = $DB->get_record('user', array('id' => $project->userid));
    } else {
        $user = $USER;
        // We need to get reload project data.
        $project = $DB->get_record('projectapp_project', array('id' => $projectid));
    }
    if (isset($project->title)) {
        $data->project_title = $project->title;
    }
    $data->fullname = fullname($user);

//    profile_load_data($user);
//    $fields = explode(',', get_config('mod_projectapproval')->usedfields);
//    foreach ($fields as $field) {
//        $data->$field = $user->$field;
//    }

    $subject = get_string('email_submission_subject', 'mod_projectapproval', $data);
    $message     = get_string('email_submission_message', 'mod_projectapproval', $data);
    $messagehtml = text_to_html(get_string('email_submission_message', 'mod_projectapproval',
        $data), false, false);
    $manager = $DB->get_record('user', array('id' => $instance->manager));
    $manager->mailformat = 1;  // Always send HTML version as well.
    email_to_user($manager, $supportuser, $subject, $message, $messagehtml);

    // Return to view page after submission.
    redirect($CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cmid);
}

$a = $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cmid;
$cm_link = '<a href="'.$a.'" >'.$instance->name.'</a>';
$PAGE->navbar->add($cm_link);
$header = get_string('header_submit_project', 'mod_projectapproval').' '.$instance->name;
$PAGE->set_heading($header);
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
