<?php
// This file is part of Invitation for Moodle - https://moodle.org/
//
// Invitation is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Invitation is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Invitation enrolment plugin settings and presets.
 *
 * @package    enrol_invitation
 * @copyright  2021-2024 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author     Michael Milette
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('enrol_invitation_settings', '', get_string('pluginname_desc', 'enrol_invitation')));

    // Enrol instance defaults.
    $settings->add(
        new admin_setting_heading(
            'enrol_invitation_defaults',
            get_string('enrolinstancedefaults', 'admin'),
            get_string('enrolinstancedefaults_desc', 'admin')
        )
    );

    $settings->add(
        new admin_setting_configcheckbox(
            'enrol_invitation/defaultenrol',
            get_string('defaultenrol', 'enrol'),
            get_string('defaultenrol_desc', 'enrol'),
            1
        )
    );

    $options = [ENROL_INSTANCE_ENABLED  => get_string('yes'), ENROL_INSTANCE_DISABLED => get_string('no')];
    $settings->add(
        new admin_setting_configselect(
            'enrol_invitation/status',
            get_string('status', 'enrol_invitation'),
            get_string('status_desc', 'enrol_invitation'),
            ENROL_INSTANCE_ENABLED,
            $options
        )
    );

    // Default to 2 weeks expiration.
    $settings->add(
        new admin_setting_configtext(
            'enrol_invitation/inviteexpiration',
            get_string('inviteexpiration', 'enrol_invitation'),
            get_string('inviteexpiration_desc', 'enrol_invitation'),
            1209600,
            PARAM_INT
        )
    );

    // Option to select default email subject line.
    $default = 'fullname'; // Default is course fullname.
    $name = 'enrol_invitation/defaultsubjectformat';
    $title = get_string('defaultsubjectformat', 'enrol_invitation');
    $description = get_string('defaultsubjectformat_desc', 'enrol_invitation');
    $choices = [
            'fullname' => get_string('fullnamecourse'),
            'shortname' => get_string('shortnamecourse'),
            'custom' => get_string('customnamecourse', 'enrol_invitation'), ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
}
