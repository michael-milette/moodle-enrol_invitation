<?php
// This file is not a part of Moodle - http://moodle.org/
// This is a none core contributed module.
//
// This is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The GNU General Public License
// can be see at <http://www.gnu.org/licenses/>.

/**
 * This file keeps track of upgrades to the invitation enrolment plugin
 *
 * @package    enrol
 * @subpackage invitation
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

function xmldb_enrol_invitation_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    // Moodle v2.1.0 release upgrade line
    // Put any upgrade step following this
    
    if ($oldversion < 2011100302) {

        // Changing type of field userid on table enrol_invitation to int
        $table = new xmldb_table('enrol_invitation');
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'email');

        // Launch change of type for field userid
        $dbman->change_field_type($table, $field);
        
        // Changing sign of field userid on table enrol_invitation to unsigned
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'email');

        // Launch change of sign for field userid
        $dbman->change_field_unsigned($table, $field);

        // invitation savepoint reached
        upgrade_plugin_savepoint(true, 2011100302, 'enrol', 'invitation');
    }
    
    if ($oldversion < 2011100303) {

        // Define field creatorid to be added to enrol_invitation
        $table = new xmldb_table('enrol_invitation');
        $field = new xmldb_field('creatorid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'timeused');

        // Conditionally launch add field creatorid
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // invitation savepoint reached
        upgrade_plugin_savepoint(true, 2011100303, 'enrol', 'invitation');
    }



    return true;
}
