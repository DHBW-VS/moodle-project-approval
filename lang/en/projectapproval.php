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
 * Strings for component 'projectapproval', language 'en'
 *
 * @package   mod_projectapproval
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['attendant'] = 'Name of the supervisor at DHBW';
$string['accepted'] = 'Accepted';

$string['createprojectapproval'] = '';
$string['company'] = 'Company';
$string['company_attendant'] = 'Name of the supervisor in the company';
$string['company_email'] = 'Email of the supervisor in the company';
$string['content'] = 'Description of the project';
$string['comment'] = 'Comment';
$string['comment_info_string'] = 'Comment: {$a}';
$string['callback'] = 'Callback';

$string['denied'] = 'Reject';

$string['edit_button'] = 'Save status';
$string['email_submission_subject'] = 'A registration for {$a->instancename} was submitted. ';
$string['email_submission_message'] = 'Please Login to your moodle to accept or reject the project proposal.
<a href="{$a->modlink}" >{$a->instancename}</a>';
$string['email_accepted_subject'] = 'Your registration for {$a->instancename} has been accepted.';
$string['email_accepted_message'] = 'Dear Sir/Madam {$a->fullname}, 

Your registration for {$a->instancename} has been accepted. Do not send replies to this message.

Regards';
$string['email_denied_subject'] = 'Your registration for {$a->instancename} was not accepted.';
$string['email_denied_message'] = 'Dear Sir/Madam {$a->fullname}, 

Unfortunately, your registration for {$a->instancename} was not accepted. Please submit a new proposal.

Regards';
$string['email_callback_subject'] = 'Your registration for {$a->instancename} is currently being reviewed, consultation is necessary, ';
$string['email_callback_message'] = 'Dear Sir/Madam {$a->fullname}, 

Your registration for {$a->instancename} is currently being reviewed.
Please contact the head of department for consultation.

Regards';
$string['projectapproval:addinstance'] = 'Create a course isntance of project approval';
$string['projectapproval:manage_submissions'] = 'Manage registrations';
$string['projectapproval:view'] = 'View registrations';

$string['file_encoding'] = 'encoding of the export file';

$string['header_submit_project'] = 'Details of';
$string['header_edit_project'] = 'Status of project registration';
$string['header_user_data'] = 'Registration user';

$string['locknote'] = 'non-disclosure notice';
$string['locknote_use'] = 'use non-disclosure notice';

$string['manager'] = 'manager';
$string['modulename'] = 'Project approval';
$string['modulenameplural'] = 'Project approvals';

$string['open'] = 'Open';

$string['project_download'] = '<a href="{$a}" >download project list</a>';
$string['pluginname'] = 'Project Registration';
//$string['privacy:metadata'] = 'The Projects Registration plugin does not store any personal data.';
$string['pluginadministration'] = 'Project approval module administration';
$string['project_submit'] = '<a href="{$a}" >Register your project</a>';
$string['project_needs_validation'] = 'Your registration for {$a} is currently being reviewed.<br>';
$string['project_accepted'] = 'Your registration for {$a} has been accepted.<br>';
$string['project_denied'] = 'Your registration for {$a} was rejected. Please submit a new proposal.<br>';
$string['project_callback'] = 'Your registration for {$a} is currently being reviewed and changes are required.
Please contact the head of department for more details.<br>';
$string['project_status'] = 'Status of registration';
$string['project_edit'] = '<a href="{$a}" >Edit registration</a>';
$string['project_info_string'] = 'Company: {$a->company}<br>
Name of the supervisor in the company: {$a->company_attendant}<br>
Email of the supervisor in the company: {$a->company_email}<br>
Name of the supervisor at DHBW: {$a->attendant}<br>
Title of the project: {$a->title}<br>
Description of the project: {$a->content}<br>';
$string['project_empty'] = 'No project registered';
$string['privacy:metadata:database:projectapp_project:cmid'] = 'Course module id';
$string['privacy:metadata:database:projectapp_project:userid'] = 'User id';
$string['privacy:metadata:database:projectapp_project:company'] = 'Company';
$string['privacy:metadata:database:projectapp_project:company_attendant'] = 'Name of the supervisor in the company';
$string['privacy:metadata:database:projectapp_project:company_email'] = 'Email of the supervisor in the company';
$string['privacy:metadata:database:projectapp_project:attendant'] = 'Name of the supervisor at DHBW';
$string['privacy:metadata:database:projectapp_project:title'] = 'Title of the project';
$string['privacy:metadata:database:projectapp_project:content'] = 'Description of the project';
$string['privacy:metadata:database:projectapp_project:comment'] = 'Comment';
$string['privacy:metadata:database:projectapp_project:status'] = 'Status of the submission';
$string['privacy:metadata:database:projectapp_project:locknote'] = 'non-disclosure notice';
$string['privacy:metadata:database:projectapp_project:timecreated'] = 'Creation timestamp';
$string['privacy:metadata:database:projectapp_project:timemodified'] = 'Last modified timestamp';
$string['privacy:metadata:database:projectapp_project'] = 'Project submission table';

$string['reset_url'] = '<a href="{$a}" >Reset registration</a>';
$string['report_firstname'] = 'firstname';
$string['report_lastname'] = 'lastname';
$string['report_email'] = 'email';
$string['report_company'] = 'company';
$string['report_company_attendant'] = 'company supervisor';
$string['report_company_email'] = 'company email';
$string['report_attendant'] = 'supervisor';
$string['report_title'] = 'title';
$string['report_content'] = 'content';
$string['report_comment'] = 'comment';
$string['report_status'] = 'status';
$string['report_restriction_notice'] = 'non-disclosure notice';
$string['report_timemodified'] = 'timemodified';
$string['report_timecreated'] = 'timecreated';

$string['submit'] = 'Submit registration';
$string['storno'] = 'withdraw registration';
$string['storno_url'] = '<a href="{$a}" >withdraw registration</a>';
$string['header_storno_project'] = 'withdraw registration';
$string['storno_project'] = 'Do you really want to withdraw your registration from {$a}?';
$string['storno_other_user'] = 'You cannot withdraw registrations of others';

$string['title'] = 'Titel of the project';

$string['userdata'] = 'project';

$string['usedfields'] = 'additional user fields';
$string['usedfields_hint'] = 'This fields will be added as placeholder to the manger email as {$a->profile_field_Shortname}';
$string['username'] = 'student name';
