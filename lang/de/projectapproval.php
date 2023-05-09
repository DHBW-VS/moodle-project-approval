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

$string['attendant'] = 'Name Betreuer/in an der DHBW';
$string['accepted'] = 'Akzeptiert';

$string['createprojectapproval'] = '';
$string['company'] = 'Dualer Partner';
$string['company_attendant'] = 'Name Betreuer/in beim Dualen Partner';
$string['company_email'] = 'E-Mail-Adresse Betreuer/in beim Dualen Partner';
$string['content'] = 'Erläuterung der Arbeit (Problemstellung / Zielsetzung)';
$string['comment'] = 'Kommentar';
$string['comment_info_string'] = '<b>Kommentar: {$a}</b>';
$string['callback'] = 'Rücksprache';

$string['denied'] = 'Ablehnen';

$string['edit_button'] = 'Status speichern';
$string['email_submission_subject'] = 'Eine Anmeldung zu {$a->instancename} ist eingegangen. ';
$string['email_submission_message'] = 'Sehr geehrte Studiengangsleitung,

Eine Anmeldung zu "{$a->instancename}" von "{$a->fullname}" mit dem Titel:

"{$a->project_title}"

ist eingegangen.

Bitte melden Sie sich an der Lernplattform an und bestätigen bzw. lehnen die Anmeldung ab: 
<a href="{$a->modlink}" >{$a->instancename}</a>.

Vielen Dank.';
$string['email_accepted_subject'] = 'Ihre Anmeldung zu {$a->instancename} wurde angenommen.';
$string['email_accepted_message'] = 'Sehr geehrte(r) Herr/Frau {$a->fullname}, 

Ihre Anmeldung zu "{$a->instancename}" mit dem Titel

  "{$a->project_title}"

wurde angenommen.

Mit freundlichen Grüßen

Bitte auf diese automatisch generierte E-Mail nicht direkt antworten.';
$string['email_denied_subject'] = 'Ihre Anmeldung zu {$a->instancename} wurde leider nicht angenommen';
$string['email_denied_message'] = 'Sehr geehrte(r) Herr/Frau {$a->fullname}, 

Ihre Anmeldung zu "{$a->instancename}" wurde leider nicht angenommen. Bitte reichen Sie einen neuen Vorschlag ein.

Mit freundlichen Grüßen';
$string['email_callback_subject'] = 'Zu Ihrer Anmeldung zu "{$a->instancename}" bittet die Studiengangsleitung um Rücksprache';
$string['email_callback_message'] = 'Sehr geehrte(r) Herr/Frau {$a->fullname}, 

zu Ihrer Anmeldung zu "{$a->instancename}" bittet die Studiengangsleitung um Rücksprache.

Mit freundlichen Grüßen';
$string['projectapproval:addinstance'] = 'Instanz anlegen';
$string['projectapproval:manage_submissions'] = 'Anmeldungen verwalten';
$string['projectapproval:view'] = 'Anmeldungen ansehen';

$string['file_encoding'] = 'Zeichencodierung der Export-Datei';

$string['header_submit_project'] = 'Angaben zu';
$string['header_edit_project'] = 'Status der Anmeldung';
$string['header_user_data'] = 'Beantragender Nutzer';

$string['locknote'] = 'Sperrvermerk';
$string['locknote_use'] = 'Sperrvermerk verwenden';

$string['manager'] = 'Studiengangsleitung';
$string['modulename'] = 'Projekt-Anmeldung';
$string['modulenameplural'] = 'Projekt-Anmeldungen';
$string['matr'] = 'Matrikelnummer';

$string['open'] = 'Offen';

$string['project_download'] = '<a href="{$a}" >Anmeldungen herunterladen</a>';
$string['pluginname'] = 'Projekt Anmeldung';
//$string['privacy:metadata'] = 'The Project submit plugin does not store any personal data.';
$string['pluginadministration'] = 'Projekt-Anmeldung Modul Administration';
$string['project_submit'] = '<a href="{$a}" >Eine wissenschaftliche Arbeit anmelden</a>';
$string['project_needs_validation'] = 'Ihre Anmeldung zu "{$a}" wird zur Zeit geprüft.';
$string['project_accepted'] = 'Ihre Anmeldung zu "{$a}" wurde angenommen.';
$string['project_denied'] = 'Ihre Anmeldung zu "{$a}" wurde leider nicht angenommen. Bitte reichen Sie einen neuen Vorschlag ein.';
$string['project_callback'] = 'Ihre Anmeldung zu "{$a}" wurde noch nicht akzeptiert und muss überarbeitet werden. Kontaktieren Sie ggf. die Studiengangsleitung.';
$string['project_status'] = 'Status der Anmeldung';
$string['project_edit'] = '<a href="{$a}" >Anmeldung bearbeiten</a>';
$string['project_info_string'] = '<table>
<tr><td style="vertical-align: text-top; font-weight: bold;">Dualer Partner:</td> 
    <td style="vertical-align: text-top;">{$a->company}</td></tr>
<tr><td style="vertical-align: text-top; font-weight: bold;">Name Betreuer/in beim Dualen Partner:</td> 
    <td style="vertical-align: text-top;">{$a->company_attendant}</td></tr>
<tr><td style="vertical-align: text-top; font-weight: bold;">E-Mail-Adresse Betreuer/in beim Dualen Partner:</td> 
    <td  style="vertical-align: text-top;"> {$a->company_email}</td></tr>
<tr><td style="vertical-align: text-top; font-weight: bold;">Name Betreuer/in an DHBW: </td> 
    <td  style="vertical-align: text-top;">{$a->attendant}</td></tr>
<tr><td style="vertical-align: text-top; font-weight: bold;">Titel der Arbeit: </td> 
    <td  style="vertical-align: text-top;">{$a->title}</td></tr>
<tr><td style="vertical-align: text-top; font-weight: bold;">Erläuterung der Arbeit: </td> 
    <td  style="vertical-align: text-top;">{$a->content}</td></tr>
</table>';
$string['project_empty'] = 'Keine Anmeldungen eingegangen';
$string['privacy:metadata:database:projectapp_project:cmid'] = 'Kurs Aktivitäts id';
$string['privacy:metadata:database:projectapp_project:userid'] = 'Nutzer id';
$string['privacy:metadata:database:projectapp_project:company'] = 'Dualer Partner';
$string['privacy:metadata:database:projectapp_project:company_attendant'] = 'Name Betreuer/in beim Dualen Partner';
$string['privacy:metadata:database:projectapp_project:company_email'] = 'E-Mail-Adresse Betreuer/in beim Dualen Partner';
$string['privacy:metadata:database:projectapp_project:attendant'] = 'Name Betreuer/in an DHBW';
$string['privacy:metadata:database:projectapp_project:title'] = 'Titel der Arbeit';
$string['privacy:metadata:database:projectapp_project:content'] = 'Erläuterung der Arbeit';
$string['privacy:metadata:database:projectapp_project:comment'] = 'Kommentar';
$string['privacy:metadata:database:projectapp_project:status'] = 'Status der Einreichung';
$string['privacy:metadata:database:projectapp_project:locknote'] = 'Sperrvermerk';
$string['privacy:metadata:database:projectapp_project:timecreated'] = 'Zeitstempel der Beantragung';
$string['privacy:metadata:database:projectapp_project:timemodified'] = 'Zeitstempel der letzten Änderung';
$string['privacy:metadata:database:projectapp_project'] = 'Tabelle der Anmeldungen';

$string['reset_url'] = '<a href="{$a}" >Anmeldung zurücksetzen</a>';
$string['report_firstname'] = 'Vorname';
$string['report_lastname'] = 'Nachname';
$string['report_email'] = 'E-Mail';
$string['report_company'] = 'Dualer Partner';
$string['report_company_attendant'] = 'Name Betreuer/in beim Dualen Partner';
$string['report_company_email'] = 'E-Mail-Adresse Betreuer/in beim Dualen Partner';
$string['report_attendant'] = 'Name Betreuer/in an der DHBW';
$string['report_title'] = 'Titel der Arbeit';
$string['report_content'] = 'Erläuterung der Arbeit';
$string['report_comment'] = 'Kommentar';
$string['report_status'] = 'Status der Einreichung';
$string['report_restriction_notice'] = 'Sperrvermerk';
$string['report_timemodified'] = 'Zeitstempel der letzten Änderung';
$string['report_timecreated'] = 'Zeitstempel der Beantragung';

$string['submit'] = 'Anmeldung einreichen';
$string['storno'] = 'Anmeldung stornieren';
$string['storno_url'] = '<a href="{$a}" >Anmeldung stornieren</a>';
$string['header_storno_project'] = 'Anmeldung stornieren';
$string['storno_project'] = 'Anmeldung zu {$a} wirklich stornieren?';
$string['storno_other_user'] = 'Sie können keine Anmeldung anderer stornieren';


$string['title'] = 'Titel der Arbeit';

$string['usedfields'] = 'Zusätzliche Nutzerfelder';
$string['usedfields_hint'] = 'Diese extra Felder werden in der email an die Studiengangsleitung als Platzhalter in der Form {$a->profile_field_Kurzbezeichnung} bereitgestellt';
$string['username'] = 'Name Studierender';
