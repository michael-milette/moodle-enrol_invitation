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
 * This page try to enrol the user
 *
 * @package    enrol
 * @subpackage invitation
 * @copyright  2011 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require($CFG->dirroot . '/enrol/invitation/locallib.php');

require_login();

//check if param token exist
$enrolinvitationtoken = required_param('enrolinvitationtoken', PARAM_ALPHANUM);

if (!empty($enrolinvitationtoken)) {

    $id = required_param('id', PARAM_INT);

    //retrieve the token info
    $invitation = $DB->get_record('enrol_invitation', array('token' => $enrolinvitationtoken, 'tokenused' => false));

    //if token is valid, enrol the user into the course          
    if (empty($invitation) or empty($invitation->courseid) or ($invitation->courseid != $id)) {
        throw new moodle_exception('expiredtoken', 'enrol_invitation');
    }

    //get
    $invitationmanager = new invitation_manager($id);
    $instance = $invitationmanager->get_invitation_instance($id);

    //First multiple check related to the invitation plugin config

    if (isguestuser()) {
        // can not enrol guest!!
        return null;
    }
    if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
        //TODO: maybe we should tell them they are already enrolled, but can not access the course
        return null;
    }

    if ($instance->enrolstartdate != 0 and $instance->enrolstartdate > time()) {
        //TODO: inform that we can not enrol yet
        return null;
    }

    if ($instance->enrolenddate != 0 and $instance->enrolenddate < time()) {
        //TODO: inform that enrolment is not possible any more
        return null;
    }

    if (empty($instance->roleid)) {
        return null;
    }

    //enrol the user into the course
    require_once($CFG->dirroot . '/enrol/invitation/locallib.php');
    $invitationmanager = new invitation_manager($invitation->courseid);
    $invitationmanager->enroluser();

    //Set token as used
    $invitation->tokenused = true;
    $invitation->timeused = time();
    $invitation->userid = $USER->id;
    $DB->update_record('enrol_invitation', $invitation);

    //send an email to the user who sent the invitation        
    $teacher = $DB->get_record('user', array('id' => $invitation->creatorid));
    $contactuser = new stdClass;
    $contactuser->email = $teacher->email;
    $contactuser->firstname = $teacher->firstname;
    $contactuser->lastname = $teacher->lastname;
    $contactuser->maildisplay = true;
    $emailinfo = new stdClass();
    $emailinfo->userfullname = $USER->firstname . ' ' . $USER->lastname;
    $courseenrolledusersurl = new moodle_url('/enrol/users.php', array('id' => $invitation->courseid));
    $emailinfo->courseenrolledusersurl = $courseenrolledusersurl->out(false);
    $course = $DB->get_record('course', array('id' => $invitation->courseid));
    $emailinfo->coursefullname = $course->fullname;
    $emailinfo->sitename = $SITE->fullname;
    $siteurl = new moodle_url('/');
    $emailinfo->siteurl = $siteurl->out(false);
    email_to_user($contactuser, get_admin(), get_string('emailtitleuserenrolled', 'enrol_invitation', $emailinfo), get_string('emailmessageuserenrolled', 'enrol_invitation', $emailinfo));

    $courseurl = new moodle_url('/course/view.php', array('id' => $id));
    redirect($courseurl);
}