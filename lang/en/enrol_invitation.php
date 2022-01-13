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
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Global strings.
$string['pluginname'] = 'Invitation';
$string['pluginname_desc'] = 'The Invitation module allows sending invitations by email. These invitations can be used only once. Users clicking on the email link are automatically enrolled.';

// Logging strings.
$string['event_invitation_accepted'] = 'Invitation Accepted';
$string['event_invitation_attempted'] = 'Invitation Attempted';
$string['event_invitation_deleted'] = 'Invitation Deleted';
$string['event_invitation_sent'] = 'Invitation Sent';
$string['event_invitation_updated'] = 'Invitation Updated';
$string['event_invitation_viewed'] = 'Invitation Viewed';
$string['event_invitation_rejected'] = 'Invitation Rejected';

// Email message strings.
$string['reminder'] = 'Reminder: ';

$string['emailmsgtxt'] = '<h2>{$a->fullname} invitation</h2><p>You have been invited to access the site:<b>{$a->fullname}</b>. Course is available from <b>{$a->start}</b> to <b>{$a->end}</b> , on location <b>{$a->location}</b>. You will need to log in to confirm your access to the site. Be advised that by clicking on the site access link provided in this email you are acknowledging that:</p>
<ul>
    <li>You are the person to whom this email was addressed and for whom this invitation is intended;</li>
    <li>The link below will expire on <b>{$a->expiration}</b>.</li>
</ul>';

$string['emailmsghtml'] = 'Preview';
$string['emailmsghtml_help'] = '<p>Good day,</p>
<p>You are invited to join the following course:</p>
<ul>
  <li>Course name: <b>{$a->coursename}</b></li>
  <li>Start date: <b>{$a->start}</b></li>
  <li>End date: <b>{$a->end}</b></li>
</ul>
{$a->message}
<p>Sign-in to confirm your enrolment in the course.</p>
<p>By using this link, you are acknowledging that you are the person to whom this email was addressed and for whom this invitation is intended.</p>
<p><a class="btn btn-primary" href="{$a->inviteurl}">{$a->acceptinvitation}</a></p>
<p>If you do not want to join this course, please use the following link instead:</p>
<p><a class="btn btn-danger" href="{$a->rejecturl}">{$a->rejectinvitation}</a></p>
<p>Note that these links will expire on <b>{$a->expiration}</b></p>
<p>Hope to see you in the course.</p>
';

$string['noenddate'] = 'No end date';

$string['emailmsgunsubscribe'] = '<span class="apple-link">If you believe that you have received this message in error, are in need of assistance or do not wish to receive further invitations for this course, please contact:</span> <a href="mailto:{$a->supportemail}">{$a->supportemail}</a>.';

// Invite form strings.
$string['assignrole'] = 'Assign role';
$string['defaultinvitevalues'] = 'Default invitation values';
$string['usedefaultvalues'] = 'Use invitation with default values';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during invitation enrollments';
$string['default_subject'] = 'Course invitation: {$a}';
$string['editenrollment'] = 'Edit enrollment';
$string['header_email'] = 'Who do you want to invite?';
$string['emailaddressnumber'] = 'Email address';
$string['close'] = 'Close';
$string['err_userlist'] = 'Or you must select users here.';
$string['err_cohortlist'] = 'Or you must select cohorts here.';
$string['notifymsg'] = 'Hello, I would like to inform you that user $a->username, with email $a->email has successful gained access to your course, $a->course';
$string['successenroled'] = 'You have been successfully enrolled to the course {$a->coursefullname}';

$string['emailtitleuserenrolled'] = '{$a->userfullname} has accepted invitation to {$a->coursefullname}.';
$string['emailmessageuserenrolled'] = 'Hello,

{$a->userfullname} ({$a->useremail}) has accepted your invitation to access {$a->coursefullname} as a "{$a->rolename}". You can verify the  status of this invitation by viewing either:

* Participant list: {$a->courseenrolledusersurl}
* Invitation history: {$a->invitehistoryurl}

{$a->sitename}
-------------
{$a->supportemail}';

$string['enrolenddate'] = 'Access end date';
$string['enrolenddate_help'] = 'If enabled, will be the date the invitee will no longer be able to access the site.';
$string['enrolenddaterror'] = 'Access end date cannot be earlier than today';
$string['enrolperiod'] = 'enrollment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrollment is valid (in seconds). If set to zero, the enrollment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrollment is valid, starting with the moment the user is enrolled. If disabled, the enrollment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['editenrolment'] = 'Edit enrolment';
$string['inviteexpiration'] = 'Invitation expiration';
$string['inviteexpiration_desc'] = 'Length of time that an invitation is valid (in seconds). Default is 2 weeks.';

$string['show_from_email'] = 'Allow invited user to contact me at {$a->email} (your address will be on the "FROM" field. If not selected, the "FROM" field will be {$a->supportemail})';
$string['fromuserconfig'] = 'Default invitation from user';
$string['inviteusers'] = 'Invite users';
$string['maxinviteerror'] = 'It must be a number.';
$string['maxinviteperday'] = 'Maximum invitation per day';
$string['maxinviteperday_help'] = 'Maximum invitation that can be send per day for a course.';
$string['message'] = 'Message';
$string['message_help_link'] = 'see what instructions invitees are sent';
$string['noinvitationinstanceset'] = 'No invitation enrollment instance has been found. Please add an invitation enroll instance to your course first.';
$string['nopermissiontosendinvitation'] = 'No permission to send invitation';
$string['norole'] = 'Please choose a role.';
$string['notify_inviter'] = 'Notify me at {$a->email} when invited users accept this invitation';
$string['registeredonly'] = 'Send invitation only for registered users';
$string['registeredonly_help'] = 'Invitation will be sent only to emails, which belongs to registered users.';
$string['header_role'] = 'What role do you want to assign to the invitee?';
$string['email_clarification'] = 'You may specify multiple email addresses by separating them with semi-colons, commas, spaces, or new lines';
$string['subject'] = 'Subject';
$string['status'] = 'Allow invitations';
$string['status_desc'] = 'Allow users to invite people to enroll into a course by default.';
$string['unenrol'] = 'Unenroll user';
$string['unenroluser'] = 'Do you really want to unenroll "{$a->user}" from course "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Do you really want to unenroll yourself from course "{$a}"?';
$string['enrolconfimation'] = 'Require student confirmation of enrolment';
$string['defaultsubjectformat'] = 'Default subject format';
$string['defaultsubjectformat_desc'] = 'This is the default course name format that will be used in the subject line when sending invitation emails. Note that this will only affect instances of the enrolment method when they are first created. If you select <strong>custom format</strong>, you can <a href="../tool/customlang/">customize the <strong>\'customsubjectformat\'</strong> language string</a> of the <strong>enrol_invitation</strong> plugin using any combination of short and/or long course names. When this plugin is first installed, the custom format is set to \'shortname - fullname\'.';
$string['customnamecourse'] = 'Custom format';
$string['customsubjectformat'] = '{$a->shortname} - {$a->fullname}';

// After invite sent strings.
$string['invitationsuccess'] = 'Invitation successfully sent';
$string['revoke_invite_sucess'] = 'Invitation successfully revoked';
$string['extend_invite_sucess'] = 'Invitation successfully extended';
$string['resend_invite_sucess'] = 'Invitation successfully resent';
$string['returntocourse'] = 'Return to course';
$string['returntoinvite'] = 'Send another invite';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Invitation acceptance';
$string['expiredtoken'] = 'Invitation token is expired or has already been used.';
$string['usernotmatch'] = '<p>The invitation is intended for a different user.</p>';
$string['loggedinnot'] = '<p>You must log in before you can accept this invitation.</p>';
$string['invtitation_rejected_notice'] = '<p>This invitation has been rejected.</p>';
$string['invitationacceptance'] = '<p>You are invited to access <strong>{$a->coursefullname}</strong> as a <strong>{$a->rolename}</strong>. Please confirm your acceptance to join this course.</p>';
$string['invitationacceptancebutton'] = 'Accept invitation';
$string['invitationrejectbutton'] = 'Reject invitation';

// Invite history strings.
$string['invitehistory'] = 'Invite history';
$string['noinvitehistory'] = 'No invites sent out yet';
$string['historyinvitee'] = 'Invitee';
$string['historyrole'] = 'Role';
$string['historystatus'] = 'Status';
$string['historydatesent'] = 'Date sent';
$string['historydateexpiration'] = 'Expiration date';
$string['historyactions'] = 'Actions';
$string['historyundefinedrole'] = 'Unable to find role. Please resent invite and choose another role.';
$string['historyexpires_in'] = 'expires in';
$string['used_by'] = ' by {$a->username} ({$a->roles}, {$a->useremail}) on {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = 'Invalid';
$string['status_invite_expired'] = 'Expired';
$string['status_invite_used'] = 'Accepted';
$string['status_invite_used_noaccess'] = '(no longer has access)';
$string['status_invite_used_expiration'] = '(access ends on {$a})';
$string['status_invite_revoked'] = 'Revoked';
$string['status_invite_resent'] = 'Resent';
$string['status_invite_active'] = 'Active';
$string['status_invite_rejected'] = 'Rejected';

// Invite action strings.
$string['action_revoke_invite'] = 'Revoke invite';
$string['action_extend_invite'] = 'Extend invite';
$string['action_resend_invite'] = 'Resend invite';

// Capabilities strings.
$string['invitation:config'] = 'Configure invitation instances';
$string['invitation:enrol'] = 'Invite users';
$string['invitation:manage'] = 'Manage invitation assignments';
$string['invitation:unenrol'] = 'Unassign users from the course';
$string['invitation:unenrolself'] = 'Unassign self from the course';

// Strings for datetime helpers.
$string['less_than_x_seconds'] = 'less than {$a} seconds';
$string['half_minute'] = 'half a minute';
$string['less_minute'] = 'less than a minute';
$string['a_minute'] = '1 minute';
$string['x_minutes'] = '{$a} minutes';
$string['about_hour'] = 'about 1 hour';
$string['about_x_hours'] = 'about {$a} hours';
$string['a_day'] = '1 day';
$string['x_days'] = '{$a} days';
