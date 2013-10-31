<?php
// This file is part of the UCLA Site Invitation Plugin for Moodle - http://moodle.org/
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
 * Invitation enrolments plugin settings and presets.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('enrol_invitation_settings', '', get_string('pluginname_desc', 'enrol_invitation')));

    // Enrol instance defaults.
    $settings->add(new admin_setting_heading('enrol_invitation_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_invitation/status',
        get_string('status', 'enrol_invitation'), get_string('status_desc', 'enrol_invitation'), ENROL_INSTANCE_ENABLED, $options));

    // Default to 2 weeks expiration.
    $settings->add(new admin_setting_configtext('enrol_invitation/inviteexpiration',
        get_string('inviteexpiration', 'enrol_invitation'), get_string('inviteexpiration_desc', 'enrol_invitation'), 1209600, PARAM_INT));
}