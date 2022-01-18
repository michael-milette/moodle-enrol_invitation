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
 * Page to send invitation.
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/invitation_form.php');
require_once($CFG->dirroot . '/enrol/locallib.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$courseurl = new moodle_url('/course/view.php', array('id' => $courseid));

$inviteid = optional_param('inviteid', 0, PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$fullname = $course->fullname;
$context = context_course::instance($courseid);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/enrol/invitation/invitation.php', array('courseid' => $courseid)));
$PAGE->set_pagelayout('course');
$PAGE->set_course($course);
$pagetitle = get_string('inviteusers', 'enrol_invitation');
$PAGE->set_heading($pagetitle);
$PAGE->set_title($pagetitle);
$PAGE->navbar->add($pagetitle);

echo $OUTPUT->header();

// Print out a heading.
echo $OUTPUT->heading($pagetitle, 2, 'headingblock');

if (!has_capability('enrol/invitation:enrol', $context)) {
    echo $OUTPUT->notification(get_string('success'), 'notifysuccess');
    $return = new moodle_url('/');
    echo $OUTPUT->continue_button($return);
    echo $OUTPUT->footer();
    exit;
}

print_page_tabs('invite');  // OUTPUT page tabs.

$invitationmanager = new invitation_manager($courseid);

// Make sure that site has invitation plugin installed.
$instance = $invitationmanager->get_invitation_instance($courseid, true);

// If the user was sent to this page by selecting 'resend invite', then
// prefill the form with the data used to resend the invite.
$prefilled = array();
if ($inviteid) {
    if ( $invite = $DB->get_record('enrol_invitation', array('courseid' => $courseid, 'id' => $inviteid)) ) {
        $prefilled['roleid'] = $invite->roleid;
        $prefilled['email'] = $invite->email;
        $prefilled['subject'] = $invite->subject;
        $prefilled['message'] = $invite->message;
        $prefilled['show_from_email'] = $invite->show_from_email;
        $prefilled['notify_inviter'] = $invite->notify_inviter;
    } else {
        throw new moodle_exception('invalidinviteid');
    }
}

if ($instance->customint1 == 1) {
    $mform = new invitation_email_form(null,
            array('course' => $course, 'context' => $context, 'prefilled' => $prefilled, 'registeredonly' => $instance->customint5,
            'instance' => $instance), 'post', '', array('class' => 'mform-invite'));
} else {
    $mform = new invitation_form(null,
            array('course' => $course, 'context' => $context, 'prefilled' => $prefilled, 'registeredonly' => $instance->customint5,
            'instance' => $instance), 'post', '', array('class' => 'mform-invite'));
}

$mform->set_data($invitationmanager);

$data = $mform->get_data();

if ($data && $instance->customint1 == 1) {
    $data->role_group = array('roleid' => $instance->customint2);
    $data->subject = $instance->customchar1;
    $data->show_from_email = $instance->customint3;
    $data->notify_inviter = $instance->customint4;
}

if ($data and confirm_sesskey()) {
    $data->registeredonly = $instance->customint5;
    // Check for the invitation of multiple users.
    $delimiters = "/[;, \r\n]/";
    $emaillist = invitation_form::parsedsvemails($data->email, $delimiters);
    $userlistmails = invitation_form::parse_userlist_emails($data->userlist);
    if (isset($data->cohortlist)) {
        $cohortmails = invitation_form::parse_cohortlist_emails($data->cohortlist, $course);
        $emaillist = array_merge($emaillist, $userlistmails, $cohortmails);
    } else {
        $emaillist = array_merge($emaillist, $userlistmails);
    }
    $emaillist = array_unique($emaillist);

    foreach ($emaillist as $email) {
        $data->email = $email;
        $invitationmanager->send_invitations($data);
    }
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    $courseret = new single_button($courseurl, get_string('returntocourse', 'enrol_invitation'), 'get');

    $secturl = new moodle_url('/enrol/invitation/invitation.php', array('courseid' => $courseid));
    $sectret = new single_button($secturl, get_string('returntoinvite', 'enrol_invitation'), 'get');

    if (!empty($prefilled)) { // Resend.
        echo $OUTPUT->confirm(get_string('resend_invite_sucess', 'enrol_invitation'), $sectret, $courseret);
    } else { // Send.
        echo $OUTPUT->confirm(get_string('invitationsuccess', 'enrol_invitation'), $sectret, $courseret);
    }

} else {
    $mform->display();
}

echo $OUTPUT->footer();
