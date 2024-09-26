<?php
// This file is part of Invitation for Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol_invitation
 * @copyright  2021-2024 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author     Michael Milette
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['a_day'] = '1 day';
$string['a_minute'] = '1 minute';
$string['about_hour'] = 'about 1 hour';
$string['about_x_hours'] = 'about {$a} hours';
$string['accepteddescription'] = 'User id {$a->userid} accepted an invitation for course with id \'{$a->courseid}\'.';
$string['action_extend_invite'] = 'Extend invite';
$string['action_resend_invite'] = 'Resend invite';
$string['action_revoke_invite'] = 'Revoke invite';
$string['anonymoususer'] = '(unknown)';
$string['assignrole'] = 'Assign role';
$string['assigngroup'] = 'Assign groups';
$string['customnamecourse'] = 'Custom format';
$string['customsubjectformat'] = '{$a->shortname} - {$a->fullname}';
$string['default_subject'] = 'Course invitation: {$a}';
$string['defaultinvitevalues'] = 'Default invitation values';
$string['defaultsubjectformat'] = 'Default subject format';
$string['defaultsubjectformat_desc'] = 'This is the default course name format that will be used in the subject line when sending invitation emails. Note that this will only affect instances of the enrolment method when they are first created. If you select <strong>custom format</strong>, you can <a href="../admin/tool/customlang/">customize the <strong>\'customsubjectformat\'</strong> language string</a> of the <strong>enrol_invitation</strong> plugin using any combination of short and/or long course names. When this plugin is first installed, the custom format is set to \'shortname - fullname\'.';
$string['deleteddescription'] = 'User id {$a->userid} deleted an invitation for course with id \'{$a->courseid}\' to \'{$a->email}\'.';
$string['editenrolment'] = 'Edit enrolment';
$string['email_clarification'] = 'You may specify multiple email addresses by separating them with semi-colons, commas, spaces, or new lines';
$string['emailaddressnumber'] = 'Email address';
$string['emailmessageuserenrolled'] = 'Hello,

{$a->userfullname} ({$a->useremail}) has accepted your invitation to access {$a->coursefullname} as a "{$a->rolename}". You can verify the  status of this invitation by viewing either:

* Participant list: {$a->courseenrolledusersurl}
* Invitation history: {$a->invitehistoryurl}

{$a->sitename}
-------------
{$a->supportemail}';
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
$string['emailmsgunsubscribe'] = '<span class="apple-link">If you believe that you have received this message in error, are in need of assistance or do not wish to receive further invitations for this course, please contact:</span> <a href="mailto:{$a->supportemail}">{$a->supportemail}</a>.';
$string['emailtitleuserenrolled'] = '{$a->userfullname} has accepted invitation to {$a->coursefullname}.';
$string['enrolconfimation'] = 'Require student confirmation of enrolment';
$string['err_cohortlist'] = 'Or you must select cohorts here.';
$string['err_userlist'] = 'Or you must select users here.';
$string['event_invitation_accepted'] = 'Accept';
$string['event_invitation_attempted'] = 'Attempt';
$string['event_invitation_deleted'] = 'Deleted';
$string['event_invitation_rejected'] = 'Rejection';
$string['event_invitation_sent'] = 'Send';
$string['event_invitation_updated'] = 'Updated';
$string['event_invitation_viewed'] = 'Viewed';
$string['expiredtoken'] = 'Invitation token is expired or has already been used.';
$string['extend_invite_sucess'] = 'Invitation successfully extended';
$string['failuredescription'] = 'Failure: User id {$a->userid}, course id \'{$a->courseid}\'. Reason: {$a->errormsg}.';
$string['half_minute'] = 'half a minute';
$string['header_email'] = 'Who do you want to invite?';
$string['header_role'] = 'What role do you want to assign to the invitee?';
$string['header_group'] = 'What group do you want to assign to the invitee?';
$string['historyactions'] = 'Actions';
$string['historydateexpiration'] = 'Expiration date';
$string['historydatesent'] = 'Date sent';
$string['historyexpires_in'] = 'expires in';
$string['historyinvitee'] = 'Invitee';
$string['historyrole'] = 'Role';
$string['historystatus'] = 'Status';
$string['historyundefinedrole'] = 'Unable to find role. Please resent invite and choose another role.';
$string['invitation:config'] = 'Configure invitation instances';
$string['invitation:enrol'] = 'Invite users';
$string['invitation:manage'] = 'Manage invitation assignments';
$string['invitation:unenrol'] = 'Unassign users from the course';
$string['invitation:unenrolself'] = 'Unassign self from the course';
$string['invitation_acceptance_title'] = 'Invitation acceptance';
$string['invitationacceptance'] = '<p>You are invited to access <strong>{$a->coursefullname}</strong> as a <strong>{$a->rolename}</strong>. Please confirm your acceptance to join this course.</p>';
$string['invitationacceptancebutton'] = 'Accept invitation';
$string['invitationrejectbutton'] = 'Reject invitation';
$string['invitationrejected'] = 'Invitation rejected';
$string['invitationsuccess'] = 'Invitation successfully sent';
$string['inviteexpiration'] = 'Invitation expiration';
$string['inviteexpiration_desc'] = 'Length of time that an invitation is valid (in seconds). Default is 2 weeks.';
$string['invitehistory'] = 'Invite history';
$string['inviteusers'] = 'Invite users';
$string['invtitation_rejected_notice'] = '<p>This invitation has been rejected.</p>';
$string['less_minute'] = 'less than a minute';
$string['less_than_x_seconds'] = 'less than {$a} seconds';
$string['loggedinnot'] = '<p>You must log in before you can accept this invitation.</p>';
$string['message'] = 'Message';
$string['message_help_link'] = 'see what instructions invitees are sent';
$string['noenddate'] = 'No end date';
$string['noinvitationinstanceset'] = 'No invitation enrollment instance has been found. Please add an invitation enroll instance to your course first.';
$string['noinvitehistory'] = 'No invites sent out yet';
$string['nopermissiontosendinvitation'] = 'No permission to send invitation';
$string['norole'] = 'Please choose a role.';
$string['notify_inviter'] = 'Notify me at {$a->email} when invited users accept this invitation';
$string['notsentdescription'] = 'User id {a->userid} failed to send an invitation for course with id \'{a->courseid}\' because there is no account with email address \'{a->email}\'.';
$string['pluginname'] = 'Invitation';
$string['pluginname_desc'] = 'The Invitation module allows sending invitations by email. These invitations can be used only once. Users clicking on the email link are automatically enrolled.';
$string['registeredonly'] = 'Send invitation only for registered users';
$string['registeredonly_help'] = 'Invitation will be sent only to emails, which belongs to registered users.';
$string['rejecteddescription'] = 'User id {$a->userid} rejected an invitation for course with id \'{$a->courseid}\'.';
$string['reminder'] = 'Reminder: ';
$string['resend_invite_sucess'] = 'Invitation successfully resent';
$string['returntocourse'] = 'Return to course';
$string['returntoinvite'] = 'Send another invite';
$string['revoke_invite_sucess'] = 'Invitation successfully revoked';
$string['sentdescription'] = 'User id {$a->userid} sent an invitation for course with id \'{$a->courseid}\' to \'{$a->email}\'.';
$string['show_from_email'] = 'Allow invited user to contact me at {$a->email} (your address will be on the "FROM" field. If not selected, the "FROM" field will be {$a->supportemail})';
$string['status'] = 'Allow invitations';
$string['status_desc'] = 'Allow users to invite people to enroll into a course by default.';
$string['status_invite_active'] = 'Active';
$string['status_invite_expired'] = 'Expired';
$string['status_invite_invalid'] = 'Invalid';
$string['status_invite_rejected'] = 'Rejected';
$string['status_invite_resent'] = 'Resent';
$string['status_invite_revoked'] = 'Revoked';
$string['status_invite_used'] = 'Accepted';
$string['status_invite_used_expiration'] = '(access ends on {$a})';
$string['status_invite_used_noaccess'] = '(no longer has access)';
$string['subject'] = 'Subject';
$string['unenrol'] = 'Unenroll user';
$string['unenroluser'] = 'Do you really want to unenroll "{$a->user}" from course "{$a->course}"?';
$string['updateddescription'] = 'User id {$a->userid} extended the invitation for course id \'{$a->courseid} to \'{$a->email}\'.';
$string['used_by'] = ' by {$a->username} ({$a->roles}, {$a->useremail}) on {$a->timeused}';
$string['usedefaultvalues'] = 'Use invitation with default values';
$string['usernotmatch'] = '<p>The invitation is intended for a different user.</p>';
$string['vieweddescription'] = 'User id {$a->userid} viewed the invitation for course with id \'{$a->courseid}\'.';
$string['x_days'] = '{$a} days';
$string['x_minutes'] = '{$a} minutes';
