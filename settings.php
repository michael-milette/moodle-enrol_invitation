<?php
// This file is part of Invitation for Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Invitation enrolment plugin settings and presets.
 *
 * @package    enrol_invitation
 * @copyright  2021 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
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
        get_string('inviteexpiration', 'enrol_invitation'), get_string('inviteexpiration_desc', 'enrol_invitation'), 1209600,
                PARAM_INT));

      /*
        list($sort, $sortparams) = users_order_by_sql('u');
        if (!empty($sortparams)) {
            throw new coding_exception('users_order_by_sql returned some query parameters. ' .
                    'This is unexpected, and a problem because there is no way to pass these ' .
                    'parameters to get_users_by_capability. See MDL-34657.');
        }
        $userfields = 'u.id, u.username, ' . get_all_user_name_fields(true, 'u');
        $users = get_users_by_capability(context_system::instance(), 'moodle/site:approvecourse', $userfields, $sort);
        $choices = array();
            $admins = get_admins();
            foreach ($admins as $user) {
                $choices[$user->id] = fullname($user);
            }

        if (is_array($users)) {
            foreach ($users as $user) {
                $choices[$user->id] = fullname($user);
            }
        }

     $settings->add(new admin_setting_configselect_autocomplete('enrol_invitation/fromuser', new lang_string('fromuserconfig', 'enrol_invitation'), new lang_string('fromuserconfig', 'enrol_invitation'), 2, $choices));*/
}
