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
 * projectapproval module admin settings and defaults
 *
 * @package mod_projectapproval
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    global $DB, $CFG;
    require_once("$CFG->libdir/resourcelib.php");

    $configs = array();

    $options = array('utf-8' => 'utf-8', 'iso-8859-15' => 'iso-8859-15');
    $configs[] = new admin_setting_configselect('file_encoding',
        get_string('file_encoding', 'projectapproval'),
        '',
        'iso-8859-15',
        $options);

    foreach ($configs as $config) {
        $config->plugin = 'mod_projectapproval';
        $settings->add($config);
    }

    //--- modedit defaults -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('projectapprovalmodeditdefaults', get_string('modeditdefaults',
        'admin'), get_string('condifmodeditdefaults', 'admin')));
}
