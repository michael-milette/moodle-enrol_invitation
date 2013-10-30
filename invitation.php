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
 * Page to send invitations.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
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

if (!has_capability('enrol/invitation:enrol', $context)) {
    throw new moodle_exception('nopermissiontosendinvitation' , 'enrol_invitation', $courseurl);
}

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/enrol/invitation/invitation.php',
        array('courseid' => $courseid)));
$PAGE->set_pagelayout('course');
$PAGE->set_course($course);
$pagetitle = get_string('inviteusers', 'enrol_invitation');
$PAGE->set_heading($pagetitle);
$PAGE->set_title($pagetitle);
$PAGE->navbar->add($pagetitle);

echo $OUTPUT->header();

// Print out a heading.
echo $OUTPUT->heading($pagetitle, 2, 'headingblock');

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
        print_error('invalidinviteid');
    }
}

$mform = new invitation_form(null, array('course' => $course, 'prefilled' => $prefilled),
        'post', '', array('class' => 'mform-invite'));
$mform->set_data($invitationmanager);

$data = $mform->get_data();
if ($data and confirm_sesskey()) {

    // Check for the invitation of multiple users.
    $delimiters = "/[;, \r\n]/";
    $email_list = invitation_form::parse_dsv_emails($data->email, $delimiters);
    $email_list = array_unique($email_list);

    foreach ($email_list as $email) {
        $data->email = $email;
        $invitationmanager->send_invitations($data);
    }

    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    $courseret = new single_button($courseurl, get_string('returntocourse',
                            'enrol_invitation'), 'get');

    $secturl = new moodle_url('/enrol/invitation/invitation.php',
                    array('courseid' => $courseid));
    $sectret = new single_button($secturl, get_string('returntoinvite',
                            'enrol_invitation'), 'get');

    echo $OUTPUT->confirm(get_string('invitationsuccess', 'enrol_invitation'),
            $sectret, $courseret);

} else {
    $mform->display();
}

echo $OUTPUT->footer();