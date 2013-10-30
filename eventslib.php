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
 * Events library.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Automatically add enrollment plugin for newly created courses.
 *
 * @param object $param
 * @return boolean  Returns false on error, otherwise true.
 */
function add_site_invitation_plugin($param) {
    global $DB;

    // Handle different parameter types (course_created vs course_restored).
    if (isset($param->id)) {
        $courseid = $param->id;    // Course created.
    } else {
        // Only respond to course restores.
        if ($param->type != backup::TYPE_1COURSE) {
            return true;
        }
        $courseid = $param->courseid;  // Course restored.
    }

    // Make sure you aren't trying something silly like adding enrollment plugin
    // to siteid.
    if ($courseid == SITEID) {
        return false;
    }

    // This hopefully means that this plugin IS enabled.
    $invitation = enrol_get_plugin('invitation');
    if (empty($invitation)) {
        debugging('Site invitation enrolment plugin is not installed');
        return false;
    }

    // Get course object.
    $course = $DB->get_record('course', array('id' => $courseid));

    // Returns instance id, else returns null.
    $instance_id = $invitation->add_instance($course);
    if (is_null($instance_id)) {
        debugging('Cannot add site invitation for course: ' .
                $course['shortname']." ".$course['fullname']);
        return false;
    }

    return true;
}
