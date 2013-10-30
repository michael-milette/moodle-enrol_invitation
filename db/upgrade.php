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
 * This file keeps track of upgrades to the invitation enrolment plugin
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

/**
 * Performs any needed database upgrades between version upgrades.
 *
 * @param int $oldversion
 * @return boolean
 */
function xmldb_enrol_invitation_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    // Moodle v2.1.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2011100302) {

        // Changing type of field userid on table enrol_invitation to int.
        $table = new xmldb_table('enrol_invitation');
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'email');

        // Launch change of type for field userid.
        $dbman->change_field_type($table, $field);

        // Changing sign of field userid on table enrol_invitation to unsigned.
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'email');

        // Launch change of sign for field userid.
        $dbman->change_field_unsigned($table, $field);

        // Invitation savepoint reached.
        upgrade_plugin_savepoint(true, 2011100302, 'enrol', 'invitation');
    }

    if ($oldversion < 2011100303) {

        // Define field creatorid to be added to enrol_invitation.
        $table = new xmldb_table('enrol_invitation');
        $field = new xmldb_field('creatorid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'timeused');

        // Conditionally launch add field creatorid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Invitation savepoint reached.
        upgrade_plugin_savepoint(true, 2011100303, 'enrol', 'invitation');
    }

    // Add roleid, timeexpiration, added foreign keys and indexes and fixed
    // some default values.
    if ($oldversion < 2013062500) {
        $table = new xmldb_table('enrol_invitation');

        // Add fields.
        $fields[] = new xmldb_field('roleid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'userid');
        $fields[] = new xmldb_field('timeexpiration', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
                'timesent');
        foreach ($fields as $field) {
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }
        }

        // Since we are adding new columns called roleid and timeexpiration, we
        // need to convert existing invitations to use these fields.
        $existinginvitations = $DB->get_recordset('enrol_invitation');
        if ($existinginvitations->valid()) {
            require_once($CFG->dirroot . '/enrol/invitation/locallib.php');

            $enrolinstances = array();  // Cache for
            foreach ($existinginvitations as $existinginvitation) {
                // Get enrol instance, but look in cache first.
                $courseid = $existinginvitation->courseid;
                if (!isset($enrolinstances[$courseid])) {
                    $invitemanager = new invitation_manager($courseid, false);
                    $enrolinstance = $invitemanager->get_invitation_instance($courseid);
                    if (empty($enrolinstance)) {
                        // Course must have deleted enrolment plugin, skip it.
                        continue;
                    } else {
                        $enrolinstances[$courseid] = $enrolinstance;
                    }
                }
                $enrolinstance = $enrolinstances[$courseid];

                // Now, update roleid and timeexpiration.
                $existinginvitation->roleid = $enrolinstance->roleid;

                // Default to 2 weeks expiration for active invitations.
                if (empty($existinginvitation->tokenused)) {
                    $existinginvitation->timeexpiration = $existinginvitation->timesent + 1209600;
                }

                $DB->update_record('enrol_invitation', $existinginvitation, true);
            }
        }


        // Change defaults/null settings.
        $fields = array();
        $fields[] = new xmldb_field('timeused', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'timeexpiration');
        $fields[] = new xmldb_field('creatorid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'timeused');
        foreach ($fields as $field) {
            $dbman->change_field_default($table, $field);
            $dbman->change_field_notnull($table, $field);
        }

        // Add foreign keys.
        $keys[] = new xmldb_key('userid', XMLDB_KEY_FOREIGN, array('userid'), 'user', array('id'));
        $keys[] = new xmldb_key('courseid', XMLDB_KEY_FOREIGN, array('courseid'), 'course', array('id'));
        $keys[] = new xmldb_key('roleid', XMLDB_KEY_FOREIGN, array('roleid'), 'role', array('id'));
        $keys[] = new xmldb_key('creatorid', XMLDB_KEY_FOREIGN, array('creatorid'), 'user', array('id'));
        foreach ($keys as $key) {
            $dbman->add_key($table, $key);
        }

        // Add index.
        $index = new xmldb_index('token', XMLDB_INDEX_UNIQUE, array('token'));
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Invitation savepoint reached.
        upgrade_plugin_savepoint(true, 2013062500, 'enrol', 'invitation');
    }

    // Rename creatorid to inviterid & add subject, message, notify_inviter,
    // show_from_email columns.
    if ($oldversion < 2013062501) {
        $table = new xmldb_table('enrol_invitation');

        // 1) Rename creatorid to inviterid.

        // First delete old key.
        $key = new xmldb_key('creatorid', XMLDB_KEY_FOREIGN, array('creatorid'), 'user', array('id'));
        $dbman->drop_key($table, $key);

        // Rename creatorid to inviterid.
        $field = new xmldb_field('creatorid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'timeused');
        $dbman->rename_field($table, $field, 'inviterid');

        // Re-add key.
        $key = new xmldb_key('inviterid', XMLDB_KEY_FOREIGN, array('inviterid'), 'user', array('id'));
        $dbman->add_key($table, $key);

        // 2) Add subject, message, notify_inviter, show_from_email columns.
        $fields[] = new xmldb_field('subject', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'inviterid');
        $fields[] = new xmldb_field('message', XMLDB_TYPE_TEXT, 'small', null, null, null, null, 'subject');
        $fields[] = new xmldb_field('notify_inviter', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
                'message');
        $fields[] = new xmldb_field('show_from_email', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0',
                'notify_inviter');

        foreach ($fields as $field) {
            // Conditionally launch add field subject.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }
        }

        // Invitation savepoint reached.
        upgrade_plugin_savepoint(true, 2013062501, 'enrol', 'invitation');
    }

    // Fix role_assignments to include enrol_invitation.
    if ($oldversion < 2013062502) {
        /**
         * Go through each accepted invite and look for an entry in
         * role_assignments with component set to "" and userid, roleid, and
         * context match given invite's user, role, course context.
         */

        // Get all invites (use record set, since it can be huge).
        $invites = $DB->get_recordset('enrol_invitation', array('tokenused' => 1));

        if ($invites->valid()) {
            foreach ($invites as $invite) {
                // Get course context.
                $coursecontext = context_course::instance($invite->courseid);
                if (empty($coursecontext)) {
                    continue;
                }

                // Find course's enrollment plugin to use as itemid later on.
                $invitation_enrol = $DB->get_record('enrol',
                        array('enrol' => 'invitation',
                              'courseid' => $invite->courseid));
                if (empty($invitation_enrol)) {
                    continue;
                }

                // Find corresponding role_assignments record (there SHOULD only
                // be one record, but testing/playing around might result in
                // dups, just choose one).
                $role_assignment = $DB->get_record('role_assignments',
                        array('roleid' => $invite->roleid,
                              'contextid' => $coursecontext->id,
                              'userid' => $invite->userid,
                              'component' => ''),
                        '*',
                        IGNORE_MULTIPLE);
                if (empty($role_assignment)) {
                    continue;
                }

                // Set component & itemid.
                $role_assignment->component = 'enrol_invitation';
                $role_assignment->itemid    = $invitation_enrol->id;

                // Save it.
                $DB->update_record('role_assignments', $role_assignment, true);
            }
            $invites->close();
        }

        // Invitation savepoint reached.
        upgrade_plugin_savepoint(true, 2013062502, 'enrol', 'invitation');
    }

    return true;
}