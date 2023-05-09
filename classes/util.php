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
 * @author Benjamin Wolf <support@eledia.de>
 * @copyright 2022 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_projectapproval;
defined('MOODLE_INTERNAL') || die();

class util {

    /**
     * Store the data of a project submission.
     *
     * @param object $formdata data from the mform.
     * @throws \dml_exception
     */
    public function save_new_project($formdata) {
        global $DB, $USER;

        $project = $DB->record_exists('projectapp_project', array('cmid' => $formdata->cm, 'userid' => $USER->id));
        if ($project) {
            // If new submission overwrite old entry.
            $DB->delete_records('projectapp_project', array('cmid' => $formdata->cm, 'userid' => $USER->id));
        }

        $new_project = new \stdClass();
        $new_project->cmid = $formdata->cm;
        $new_project->userid = $USER->id;
        $new_project->company = $formdata->company;
        $new_project->company_attendant = $formdata->company_attendant;
        $new_project->company_email = $formdata->company_email;
        $new_project->attendant = $formdata->attendant;
        $new_project->title = $formdata->title;
        $new_project->content = $formdata->content;
        $new_project->status = 'open';
        if (!empty($formdata->locknote)) {
            $new_project->locknote = $formdata->locknote;
        }
        $new_project->timemodified = time();
        $new_project->timecreated = time();
        return $DB->insert_record('projectapp_project', $new_project);
    }

    /**
     * Store the data of a project submission.
     *
     * @param object $formdata data from the mform.
     * @throws \dml_exception
     */
    public function save_edit_project($formdata) {
        global $DB, $CFG;

        $project = $DB->get_record('projectapp_project', array('id' => $formdata->projectid));
        if (empty($project)) {
            print_error('project_not_found', 'projectapproval', $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$project->cmid,
                null, 'Project record missing '.$formdata->project);
        }
        $project->attendant = $formdata->attendant;
        $project->status = $formdata->status;
        $project->comment = $formdata->comment;
        $project->timemodified = time();

        $DB->update_record('projectapp_project', $project);
    }

    /**
     *
     * @param object $cm course module object.
     * @return string
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public function get_student_view(object $cm) {
        global $DB, $USER, $CFG;

        $content = '';
        // New project link.
        $a = $CFG->httpswwwroot.'/mod/projectapproval/project_submit.php?cm='.$cm->id;

        $project = $DB->get_record('projectapp_project', array('cmid' => $cm->id, 'userid' => $USER->id));
        $instance = $DB->get_record('projectapproval', array('id' => $cm->instance));

        // First show status.
        if (!empty($project)) {
            // Print saved data.
            $content .= get_string('project_info_string', 'mod_projectapproval', $project);
            // Add comment if any.
            if (!empty($project->comment)) {
                // Print comment if there is any.
                $content .= '<br>'.get_string('comment_info_string', 'mod_projectapproval', $project->comment);
            }
            // Check status.
            switch ($project->status) {
                case 'open':
                    $content .= '<br><br>'.get_string('project_needs_validation', 'projectapproval', $instance->name);
                    // Add reset url.
                    $reset_url = $CFG->httpswwwroot.'/mod/projectapproval/project_reset.php?projectid='.$project->id;
                    $content .= '<br>'.get_string('reset_url', 'mod_projectapproval', $reset_url);
                    // Add storno url.
                    $storno_url = $CFG->httpswwwroot.'/mod/projectapproval/project_storno.php?projectid='.$project->id;
                    $content .= '<br>'.get_string('storno_url', 'mod_projectapproval', $storno_url);
                    break;
                case 'accepted':
                    $content .= '<br><br>'.get_string('project_accepted', 'projectapproval', $instance->name);
                    break;
                case 'denied':
                    $content .= '<br><br>'.get_string('project_denied', 'projectapproval', $instance->name);
                    $content .= '<br>'.get_string('project_edit', 'projectapproval', $a);
                    // Add storno url.
                    $storno_url = $CFG->httpswwwroot.'/mod/projectapproval/project_storno.php?projectid='.$project->id;
                    $content .= '<br>'.get_string('storno_url', 'mod_projectapproval', $storno_url);
                    break;
                case 'callback':
                    $content .= '<br><br>'.get_string('project_callback', 'projectapproval', $instance->name);
                    $content .= '<br>'.get_string('project_edit', 'projectapproval', $a);
                    // Add storno url.
                    $storno_url = $CFG->httpswwwroot.'/mod/projectapproval/project_storno.php?projectid='.$project->id;
                    $content .= '<br>'.get_string('storno_url', 'mod_projectapproval', $storno_url);
                    break;
                default:
                    $content .= '<br><br>'.get_string('project_edit', 'projectapproval', $a);
                    // Add storno url.
                    $storno_url = $CFG->httpswwwroot.'/mod/projectapproval/project_storno.php?projectid='.$project->id;
                    $content .= '<br>'.get_string('storno_url', 'mod_projectapproval', $storno_url);
            }
        } else {
            // No submission yet, so only submission link here.
            $content .= get_string('project_submit', 'projectapproval', $a);
        }
        return $content;
    }

    /**
     *
     * @param object $cm course module object.
     * @param object $instance module instance object.
     * @return string
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public function get_manager_view(object $cm, $instance) {
        global $DB, $CFG;

        $content = '';
        // Collect some data.
        $projects = $DB->get_records('projectapp_project', array('cmid' => $cm->id));

        // First show status.
        if (!empty($projects)) {
            $table = new \html_table();
            $table->head  = array(get_string('username', 'projectapproval'),
                get_string('title', 'projectapproval'),
                get_string('locknote', 'projectapproval'),
                get_string('project_status', 'projectapproval'),
                get_string('attendant', 'projectapproval'),
                '');
            foreach ($projects as $project) {
                $a = $CFG->httpswwwroot.'/mod/projectapproval/project_edit.php?projectid='.$project->id;

                $user = $DB->get_record('user', array('id' => $project->userid));
                $username = $user->firstname.' '.$user->lastname;
                $locknote_string = $project->locknote ? get_string('yes') : get_string('no');
                $table->data[]  = array($username, $project->title, $locknote_string,
                    get_string($project->status, 'projectapproval'),
                    $project->attendant,
                    get_string('project_edit', 'projectapproval', $a));
            }
            $content = \html_writer::table($table);

            $download_link = $CFG->httpswwwroot.'/mod/projectapproval/view.php?id='.$cm->id.'&download=1';
            $content .= "<br>".get_string('project_download', 'projectapproval', $download_link);
        } else {
            $content .= get_string('project_empty', 'projectapproval');
        }
        // Handle download action.
        if (optional_param('download', null, PARAM_RAW)) {
            $charset = get_config('mod_projectapproval', 'file_encoding');

            // Strings for titles.
            $titles = array('report_firstname', 'report_lastname', 'report_email', 'report_company', 'report_company_attendant',
                'report_company_email', 'report_attendant', 'report_title', 'report_content', 'report_comment',
                'report_status', 'report_restriction_notice', 'report_timemodified', 'report_timecreated');
            foreach ($titles as $key => $item) {
                $item = get_string($item, 'projectapproval');
                $titles[$key] = \core_text::convert($item, 'utf-8', $charset);
            }

            $lines = array($titles);
            foreach ($projects as $project) {
                $line = array();

                // Resolve user data for export.
                $user = $DB->get_record('user', array('id' => $project->userid));
                array_push($line, $user->firstname, $user->lastname, $user->email);

                // Add project infos.
                array_push($line, $project->company, $project->company_attendant, $project->company_email,
                    $project->attendant, $project->title, $project->content, $project->comment,
                    $project->status);
                $line[] = $project->locknote ? get_string('yes') : get_string('no');

                // Reformat timestamps for export.
                array_push($line, date('H:i:s d.m.Y', $project->timemodified), date('H:i:s d.m.Y', $project->timecreated));

                // Convert to configured encoding for the export.
                foreach ($line as $key => $item) {
                    $line[$key] = \core_text::convert($item, 'utf-8', $charset);
                }
                $lines[] = $line;
            }
            $this->array_to_csv_download($lines, clean_param($instance->name, PARAM_FILE).".csv", ";", '"', $charset);
        }
        return $content;
    }

    function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";", $enclosure = '"', $charset = 'UTF-8') {
        // Clean output buffer.
        ob_end_clean();
        header('Content-Type: application/csv charset='.$charset);
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        $f = fopen('php://output', 'w');
        foreach ($array as $line) {
            fputcsv($f, (array) $line, $delimiter, $enclosure);
        }
        fclose($f);
        exit();
    }
}
