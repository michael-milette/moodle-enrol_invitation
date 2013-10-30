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
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Global strings.
$string['pluginname'] = 'Invitation';
$string['pluginname_desc'] = 'The Invitation module allows sending invitations by email. These invitations can be used only once. Users clicking on the email link are automatically enrolled.';

// Email message strings.
$string['reminder'] = 'Reminder: ';

$string['emailmsgtxt'] =
    'INSTRUCTIONS:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    'You have been invited to access the site: {$a->fullname}. You will ' .
    'need to log in to confirm your access to the site. Be advised that by ' .
    'clicking on the site access link provided in this ' .
    'email you are acknowledging that:' . "\n" .
    ' --you are the person to whom this email was addressed and for whom this' .
    '   invitation is intended;' . "\n" .
    ' --the link below will expire on ({$a->expiration}).' . "\n\n" .
    'ACCESS LINK:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a->inviteurl}' . "\n\n" .
    'If you believe that you have received this message in error or are in need ' .
    'of assistance, please contact: {$a->supportemail}.';

$string['instructormsg'] =
    'MESSAGE FROM INSTRUCTOR:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a}' . "\n\n";

// Invite form strings.
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during invitation enrollments';
$string['default_subject'] = 'Invitation for {$a}';
$string['editenrollment'] = 'Edit enrollment';
$string['header_email'] = 'Who do you want to invite?';
$string['emailaddressnumber'] = 'Email address';

$string['notifymsg'] = 'Hello, I would like to inform you that user $a->username, with email $a->email has successful gained access to your course, $a->course';


$string['emailtitleuserenrolled'] = '{$a->userfullname} has accepted invitation to {$a->coursefullname}.';
$string['emailmessageuserenrolled'] = 'Hello,

    {$a->userfullname} ({$a->useremail}) has accepted your invitation to access {$a->coursefullname} as a "{$a->rolename}". You can verify the  status of this invitation by viewing either:

        * the participant list for : {$a->courseenrolledusersurl}
        * your site invitation history: {$a->invitehistoryurl}

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

$string['show_from_email'] = 'Allow invited user to contact me at {$a->email} (your address will be on the "FROM" field. If not selected, the "FROM" field will be {$a->supportemail})';
$string['inviteusers'] = 'Invite user';
$string['maxinviteerror'] = 'It must be a number.';
$string['maxinviteperday'] = 'Maximum invitation per day';
$string['maxinviteperday_help'] = 'Maximum invitation that can be send per day for a course.';
$string['message'] = 'Message';

$string['message_help_link'] = 'see what instructions invitees are sent';
$string['message_help'] =
    'INSTRUCTIONS:'.
    '<hr />'.
    'You have been invited to access the site: [site name]. You will ' .
    'need to log in to confirm your access to the site. Be advised that by ' .
    'clicking on the site access link provided in this ' .
    'email you are acknowledging that:<br />' .
    ' --you are the person to whom this email was addressed and for whom this ' .
    '   invitation is intended;<br />' .
    ' --the link below will expire on ([expiration date]).<br /><br />' .
    'ACCESS LINK:'.
    '<hr />'.
    '[invite url]<br />'.
    '<hr />'.
    'If you believe that you have received this message in error or are in need ' .
    'of assistance, please contact: [support email].';

$string['noinvitationinstanceset'] = 'No invitation enrollment instance has been found. Please add an invitation enroll instance to your course first.';
$string['nopermissiontosendinvitation'] = 'No permission to send invitation';
$string['norole'] = 'Please choose a role.';
$string['notify_inviter'] = 'Notify me at {$a->email} when invited users accept this invitation';
$string['header_role'] = 'What role do you want to assign to the invitee?';
$string['email_clarification'] = 'You may specify multiple email addresses by separating
    them with semi-colons, commas, spaces, or new lines';
$string['subject'] = 'Subject';
$string['status'] = 'Allow site invitations';
$string['status_desc'] = 'Allow users to invite people to enroll into a course by default.';
$string['unenrol'] = 'Unenroll user';
$string['unenroluser'] = 'Do you really want to unenroll "{$a->user}" from course "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Do you really want to unenroll yourself from course "{$a}"?';

// After invite sent strings.
$string['invitationsuccess'] = 'Invitation successfully sent';
$string['revoke_invite_sucess'] = 'Invitation sucessfully revoked';
$string['extend_invite_sucess'] = 'Invitation sucessfully extended';
$string['resend_invite_sucess'] = 'Invitation sucessfully resent';
$string['returntocourse'] = 'Return to course';
$string['returntoinvite'] = 'Send another invite';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Invitation acceptance';
$string['expiredtoken'] = 'Invitation token is expired or has already been used.';
$string['loggedinnot'] = '<p>This invitation to access "{$a->coursefullname}" as
    a "{$a->rolename}" is intended for {$a->email}. If you are not the
    intended recipient, please do not accept this invitation.</p>
    <p>
        Before you can accept this invitation you must be logged in.
    </p>';
$string['invitationacceptance'] = '<p>This invitation to access
    "{$a->coursefullname}" as a "{$a->rolename}" is intended for {$a->email}.
    If you are not the intended recipient, please do not accept this invitation.</p>';
$string['invitationacceptancebutton'] = 'Accept invitation';

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
