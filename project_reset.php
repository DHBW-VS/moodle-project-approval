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
global $DB, $CFG, $USER;

$projectid = required_param('projectid', PARAM_INT);
$project = $DB->get_record('projectapp_project', array('id' => $projectid));
$cm = get_coursemodule_from_id('projectapproval', $project->cmid);

require_login();
require_capability('mod/projectapproval:view', context_module::instance($cm->id));

if ($USER->id != $project->userid) {
    // You can't reset for someone else!
    print_error('reset_other_user', 'mod_projectapproval',
        $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id);
}

$DB->set_field('projectapp_project', 'status', 'callback', array('id' => $projectid));
redirect($CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id);
