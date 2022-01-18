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
 * This page will try to enrol the user.
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require($CFG->dirroot . '/enrol/invitation/locallib.php');

// Check if param reject exists.
$reject = optional_param('reject', 0, PARAM_BOOL);

// Check if param token exist. Support checking for both old "enrolinvitationtoken" token name and new "token" parameters.
$enrolinvitationtoken = optional_param('enrolinvitationtoken', null, PARAM_ALPHANUM);
if (empty($enrolinvitationtoken)) {
    $enrolinvitationtoken = required_param('token', PARAM_ALPHANUM);
}

$url = new moodle_url('/enrol/invitation/enrol.php', ['token' => $enrolinvitationtoken]);

// Retrieve the token info.
$invitation = $DB->get_record('enrol_invitation', ['token' => $enrolinvitationtoken, 'tokenused' => false]);

// If token has been already used or has expired, display error message.
if ((empty($invitation) or empty($invitation->courseid) or $invitation->timeexpiration < time())) {
    $courseid = empty($invitation->courseid) ? $SITE->id : $invitation->courseid;
    $invitationn = $DB->get_record('enrol_invitation', ['token' => $enrolinvitationtoken]);
    $invitationn->errormsg = 'expired';
    if ($reject && $invitation->timeexpiration < time()) {
        \enrol_invitation\event\invitation_rejected::create_from_invitation($invitationn)->trigger();
    } else {
        \enrol_invitation\event\invitation_accepted::create_from_invitation($invitationn)->trigger();
    }
    $pagetitle = get_string('status_invite_expired', 'enrol_invitation');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title($pagetitle);
    $PAGE->navbar->add($pagetitle);
    $PAGE->set_url(new moodle_url('/enrol/invitation/enrol.php'));
    echo $OUTPUT->header();
    echo $OUTPUT->heading($pagetitle);
    echo $OUTPUT->box(get_string('expiredtoken', 'enrol_invitation'));
    echo $OUTPUT->continue_button(new moodle_url('/'));
    echo $OUTPUT->footer();
    exit;
}

//
// Reject invitation.
//

if ($reject) {

    $invitation->errormsg = '';
    if (isloggedin() && !isguestuser()) { // Logged-in.
        // Ensure that this is the expected user.
        if ((empty($invitation->userid) && $invitation->email == $USER->email)
                || (!empty($invitation->userid) && $invitation->userid == $USER->id)) {
            // Allow rejection if either the user did not have an account at the time of invitation (userid=null) but email
            // addresses match, OR if the user's ID matches the one in the invitation. Prevent users from swapping email addresses.
            $userid = $USER->id;
        } else if (empty($userid) && $invitation->email != $USER->email) {
            // User had no account at the time of invitation which is fine but mail addresses do not match.
            $invitation->errormsg = 'email does not match';
        } else { // If the userid does not match the current USER id, invitation was sent to a user with a different userid.
            $invitation->errormsg = 'user account id mismatch';
        }
    } else if (!empty($invitation->userid)) { // Logged-out or guest and expecting a specific user account.
        // Rejecting this invitation requires that user be logged in.
        require_login(null, false);
    } else { // Anonymous (logged-out/guest) user for unknown expected user (userid = null).
        // We allow the invitation rejection by non-authenticated visitors and guests if the invited users
        // did not have an account when the invitation was first created (userid = null).
        $userid = $invitation->userid; // Will be set to null.
    }

    if (!empty($invitation->errormsg)) {
        // This is not the expected user. Log it and display access denied message.
        \enrol_invitation\event\invitation_rejected::create_from_invitation($invitation)->trigger();
        $pagetitle = get_string('accessdenied', 'admin');
        $PAGE->set_context(context_system::instance());
        $PAGE->set_title($pagetitle);
        $PAGE->navbar->add($pagetitle);
        $PAGE->set_url($url);
        echo $OUTPUT->header();
        echo $OUTPUT->heading($pagetitle, 2, 'headingblock');
        echo $OUTPUT->box_start('generalbox', 'notice');
        echo get_string('usernotmatch', 'enrol_invitation');
        echo $OUTPUT->continue_button(new moodle_url('/'));
        echo $OUTPUT->box_end();
        echo $OUTPUT->footer();
        exit;
    }

    $pagetitle = get_string('status_invite_rejected', 'enrol_invitation');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title($pagetitle);
    $PAGE->navbar->add($pagetitle);
    $PAGE->set_url($url);
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('invitationrejected', 'enrol_invitation'), 2, 'headingblock');
    echo $OUTPUT->box_start('generalbox', 'notice');

    // Implementation for possibility to reject invitation
    // @package    enrol_invitation
    // @copyright  2021 Lukas Celinak (lukascelinak@gmail.com)
    // @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.

    // Set token as used and status to rejected.
    $invitation->tokenused = true;
    $invitation->timeused = time();
    $invitation->userid = $userid;
    $invitation->status = "rejected";

    // Log event.
    \enrol_invitation\event\invitation_rejected::create_from_invitation($invitation)->trigger();
    $DB->update_record('enrol_invitation', $invitation);

    // Display confirmation that invitation has been rejected.
    echo get_string('invtitation_rejected_notice', 'enrol_invitation');

    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}

//
// Accept Invitation.
//

// Ensure user is logged in.
require_login(null, false);

// We allow invitation acceptance by logged-in users only. Acceptance request will be rejected if a userid is set and they don't
// match or if the email address does not match. If a user created account since invitation, the userid will not match but email
// address should. This will also ensure that 2 user accounts did not swap email addresses.
if ((empty($invitation->userid) && $invitation->email == $USER->email) || $invitation->userid == $USER->id) {
    $userid = $USER->id;
} else {
    // This is not the expected user. Log and display access denied message.
    // Invitation was sent to a user with a different userid.
    $invitation->errormsg = 'user account mismatch';
    \enrol_invitation\event\invitation_accepted::create_from_invitation($invitation)->trigger();
    $pagetitle = get_string('accessdenied', 'admin');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title($pagetitle);
    $PAGE->navbar->add($pagetitle);
    $PAGE->set_url($url);
    echo $OUTPUT->header();
    echo $OUTPUT->heading($pagetitle, 2, 'headingblock');
    echo $OUTPUT->box_start('generalbox', 'notice');
    echo get_string('usernotmatch', 'enrol_invitation');
    echo $OUTPUT->continue_button(new moodle_url('/'));
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}

// Make sure that course exists.
$course = $DB->get_record('course', array('id' => $invitation->courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id);

// Set up page.
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('course');
$PAGE->set_course($course);
$pagetitle = get_string('invitation_acceptance_title', 'enrol_invitation');
$PAGE->set_heading($pagetitle);
$PAGE->set_title($pagetitle);
$PAGE->navbar->add($pagetitle);

// Get.
$invitationmanager = new invitation_manager($invitation->courseid);
$instance = $invitationmanager->get_invitation_instance($invitation->courseid);

// First multiple check related to the invitation plugin config.
// @Todo better handle exceptions here.

if (!$invitation->userid && isguestuser()) {
    // Can not enrol guest!!
    echo $OUTPUT->header();

    // Print out a heading.
    echo $OUTPUT->heading($pagetitle, 2, 'headingblock');

    echo $OUTPUT->box_start('generalbox', 'notice');
    $noticeobject = preparenoticeobject($invitation);
    echo get_string('loggedinnot', 'enrol_invitation', $noticeobject);
    $loginbutton = new single_button(new moodle_url($CFG->wwwroot . '/login/index.php'), get_string('login'));

    echo $OUTPUT->render($loginbutton);
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}

// Have invitee confirm their acceptance of the site invitation.
$confirm = optional_param('confirm', 0, PARAM_BOOL);

if ($instance->customint6 == 1 && empty($confirm)) {

    // User has not yet confirmed their acceptance.

    echo $OUTPUT->header();

    // Print out a heading.
    echo $OUTPUT->heading($pagetitle, 2, 'headingblock');

    \enrol_invitation\event\invitation_viewed::create_from_invitation($invitation)->trigger();

    $accepturl = new moodle_url('/enrol/invitation/enrol.php', ['token' => $invitation->token, 'confirm' => true]);
    $accept = new single_button($accepturl, get_string('invitationacceptancebutton', 'enrol_invitation'), 'get');
    $cancel = new moodle_url('/');

    $noticeobject = preparenoticeobject($invitation);

    $invitationacceptance = get_string('invitationacceptance', 'enrol_invitation', $noticeobject);

    // If invitation has "daysexpire" set, then give notice.
    if (!empty($invitation->daysexpire)) {
        $invitationacceptance .= html_writer::tag('p', get_string('daysexpire_notice', 'enrol_invitation',
                $invitation->daysexpire));
    }

    echo $OUTPUT->confirm($invitationacceptance, $accept, $cancel);
    echo $OUTPUT->footer();
    exit;

} else {

    // User confirmed acceptance. Enrol them in the course.

    $invitationmanager = new invitation_manager($invitation->courseid);
    $invitationmanager->enroluser($invitation);

    // Set token as used and mark which user was assigned the token.
    $invitation->tokenused = true;
    $invitation->timeused = time();
    $invitation->userid = $userid;
    \enrol_invitation\event\invitation_accepted::create_from_invitation($invitation)->trigger();
    $DB->update_record('enrol_invitation', $invitation);

    if (!empty($invitation->notify_inviter)) {
        // Send an email to the user who sent the invitation.
        $inviter = $DB->get_record('user', array('id' => $invitation->inviterid));
        $inviter->maildisplay = true;

        $emailinfo = preparenoticeobject($invitation);
        $emailinfo->userfullname = trim($user->firstname . ' ' . $user->lastname);
        $emailinfo->useremail = $user->email;
        $courseenrolledusersurl = new moodle_url('/user/index.php', ['id' => $invitation->courseid]);
        $emailinfo->courseenrolledusersurl = $courseenrolledusersurl->out(false);
        $invitehistoryurl = new moodle_url('/enrol/invitation/history.php', ['courseid' => $invitation->courseid]);
        $emailinfo->invitehistoryurl = $invitehistoryurl->out(false);

        $course = $DB->get_record('course', array('id' => $invitation->courseid));
        $emailinfo->coursefullname = sprintf('%s: %s', $course->shortname, $course->fullname);
        $emailinfo->sitename = $SITE->fullname;
        $siteurl = new moodle_url('/');
        $emailinfo->siteurl = $siteurl->out(false);

        email_to_user($inviter, get_admin(),
                get_string('emailtitleuserenrolled', 'enrol_invitation', $emailinfo),
                get_string('emailmessageuserenrolled', 'enrol_invitation', $emailinfo));
    }

    // Take the user into the course.
    $courseurl = new moodle_url('/course/view.php', array('id' => $invitation->courseid));
    redirect($courseurl);
}
