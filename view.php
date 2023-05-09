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
 * projectapproval module version information
 *
 * @package mod_projectapproval
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
global $CFG, $DB, $PAGE, $OUTPUT;
require_once($CFG->dirroot.'/mod/projectapproval/lib.php');
require_once($CFG->dirroot.'/mod/projectapproval/locallib.php');
require_once($CFG->libdir.'/completionlib.php');

use mod_projectapproval\util;

$id      = optional_param('id', 0, PARAM_INT); // Course Module ID
$p       = optional_param('p', 0, PARAM_INT);  // projectapproval instance ID

if ($p) {
    if (!$projectapproval = $DB->get_record('projectapproval', array('id'=>$p))) {
        print_error('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('projectapproval', $projectapproval->id,
        $projectapproval->course, false, MUST_EXIST);
} else {
    if (!$cm = get_coursemodule_from_id('projectapproval', $id)) {
        print_error('invalidcoursemodule');
    }
    $projectapproval = $DB->get_record('projectapproval', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/projectapproval:view', $context);
$util = new util();

// Completion and trigger events.
projectapproval_view($projectapproval, $course, $cm, $context);

$content = $projectapproval->intro;

// Check cap and switch list and personal view.
if (has_capability('mod/projectapproval:manage_submissions', $context)) {
    $content .= $util->get_manager_view($cm, $projectapproval);
} else {
    $content .= $util->get_student_view($cm);
}

$formatoptions = new stdClass;
$formatoptions->noclean = false;
$formatoptions->overflowdiv = true;
$formatoptions->context = $context;
$content = format_text($content, FORMAT_HTML, $formatoptions);

$PAGE->set_url('/mod/projectapproval/view.php', array('id' => $cm->id));

$PAGE->set_title($course->shortname.': '.$projectapproval->name);
$PAGE->set_heading($course->fullname);
$PAGE->set_activity_record($projectapproval);

echo $OUTPUT->header();

//// Display any activity information (eg completion requirements / dates).
//$cminfo = cm_info::create($cm);
//$completiondetails = \core_completion\cm_completion_details::get_instance($cminfo, $USER->id);
//$activitydates = \core\activity_dates::get_dates_for_module($cminfo, $USER->id);
//echo $OUTPUT->activity_information($cminfo, $completiondetails, $activitydates);

echo $OUTPUT->box($content, "generalbox center clearfix");
echo $OUTPUT->footer();
