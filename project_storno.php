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
global $DB, $CFG, $FULLME, $PAGE, $DB, $CFG, $OUTPUT, $USER;

$projectid = required_param('projectid', PARAM_INT);
$project = $DB->get_record('projectapp_project', array('id' => $projectid));
$cm = get_coursemodule_from_id('projectapproval', $project->cmid);

require_login();
require_capability('mod/projectapproval:view', context_module::instance($cm->id));

require_once('project_storno_form.php');
$myurl = new moodle_url($FULLME);

$PAGE->set_url($myurl);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('course');

$instance = $DB->get_record('projectapproval', array('id' => $cm->instance));
$mform = new projectstorno_form(null, array('project' => $project));

if ($mform->is_cancelled()) {
    redirect($CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id);
}
if ($formdata = $mform->get_data()) {
    if ($USER->id != $project->userid) {
        // You can't storno for someone else!
        print_error('storno_other_user', 'mod_projectapproval',
            $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id);
    }

    $DB->delete_records('projectapp_project', array('id' => $projectid));
    redirect($CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id);
}

$a = $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id;
$cm_link = '<a href="'.$a.'" >'.$instance->name.'</a>';
$PAGE->navbar->add($cm_link);
$header = get_string('header_storno_project', 'mod_projectapproval').' '.$instance->name;
$PAGE->set_heading($header);
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
