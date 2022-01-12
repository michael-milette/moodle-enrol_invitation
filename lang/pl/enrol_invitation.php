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
$string['pluginname'] = 'Zaproszenie';
$string['pluginname_desc'] = 'Moduł Zaproszenie umożliwia wysyłanie zaproszeń pocztą elektroniczną. Zaproszenia te mogą być użyte tylko raz. Użytkownicy klikający na link e-mail są automatycznie rejestrowani.';

// Email message strings.
$string['reminder'] = 'Przypomnienie: ';
$string['fromuserconfig'] = 'Default invitation from user';
$string['emailmsgtxt'] =
    '<h2>Dostęp do szkolenia:</h2>' .
    '<hr />' .
    '<p>Zostałeś/aś zaproszony/a do udziału w szkoleniu: {$a->fullname}. Musisz kliknąć poniższy link, aby zaakceptować udział w szkoleniu. <br />' .
    '<b>LINK DOSTĘPOWY:</b> ' . '{$a->inviteurl} <br />' .
    'Klikając na link dostępu do strony zamieszczony w tym e-mailu przyjmujesz do wiadomości, że: <br />' .
    '* jesteś osobą, do której adresowany był ten e-mail i dla której to zaproszenie jest przeznaczone;<br />' .
    '* powyższy link wygaśnie w dniu ({$a->expiration}).' .

    '<p>Jeśli uważasz, że otrzymałeś tę wiadomość błędnie lub potrzebujesz pomocy, prosimy o kontakt: {$a->supportemail}.</p>';

$string['instructormsg'] =
    '<h2>Informacja od instruktora:</h2>' .
    '<hr />' .
    '{$a}';

// Invite form strings.
$string['assignrole'] = 'Przypisz rolę';
$string['defaultrole'] = 'Rola domyślna';
$string['defaultinvitevalues'] = 'Default invitation values';
$string['defaultrole_desc'] = 'Wybierz rolę, która powinna być przypisana użytkownikom podczas rejestracji zaproszeń.';
$string['default_subject'] = 'Zaproszenie na kurs {$a}';
$string['editenrollment'] = 'Edycja zapisów';
$string['header_email'] = 'Kogo chcesz zaprosić?';
$string['emailaddressnumber'] = 'Adresy e-mail';
$string['registeredonly'] = 'Send invitiation only for registered users';
$string['registeredonly_help'] = 'Invitation will be sent only to emails, which belongs to registered users.';
$string['notifymsg'] = 'Witam, chciałbym poinformować, że użytkownik $a->username, z e-mailem $a->email zaakceptował dostęp do twojego kursu, $a->course';
$string['usedefaultvalues'] = 'Use invitation with default values';
$string['emailtitleuserenrolled'] = '{$a->userfullname} zaakceptował zaproszenie do {$a->coursefullname}.';
$string['emailmsgunsubscribe'] = '<span class=\"apple-link\">If you believe that you have received this message in error or are in need of assistance, please contact:</span><br>
<a href=\"mailto:{$a->supportemail}\">{$a->supportemail}</a>.';
$string['emailmessageuserenrolled'] = 'Witam,
{$a->userfullname} ({$a->useremail}) zaakceptował twoje zaproszenie do kursu {$a->coursefullname} jako a "{$a->rolename}". Status tego zaproszenia można sprawdzić, oglądając:

    * Listę uczestników: {$a->courseenrolledusersurl}
    * Historię zaproszeń: {$a->invitehistoryurl}

{$a->sitename}
-------------
{$a->supportemail}';

$string['enrolenddate'] = 'Data końca dostępu';
$string['enrolenddate_help'] = 'If enabled, will be the date the invitee will no longer be able to access the site.';
$string['enrolenddaterror'] = 'Access end date cannot be earlier than today';
$string['enrolperiod'] = 'enrollment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrollment is valid (in seconds). If set to zero, the enrollment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrollment is valid, starting with the moment the user is enrolled. If disabled, the enrollment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['editenrolment'] = 'Edit enrolment';
$string['inviteexpiration'] = 'Wygaśnięcie zaproszenia';
$string['inviteexpiration_desc'] = 'Czas ważności zaproszenia (w sekundach). Domyślnie jest to 2 tygodnie.';

$string['show_from_email'] = 'Pozwól zaproszonemu użytkownikowi skontaktować się ze mną pod adresem {$a->email} (Twój adres będzie w polu "FROM". Jeśli nie zaznaczono tego pola, w polu "FROM" będzie {$a->supportemail})';
$string['inviteusers'] = 'Zaproś użytkownika';
$string['maxinviteerror'] = 'To musi być numer.';
$string['maxinviteperday'] = 'Maksymalna liczba zaproszeń na dzień';
$string['maxinviteperday_help'] = 'Maksymalna liczba zaproszeń do kursu, które można wysłać dziennie.';
$string['message'] = 'Wiadomość';

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

$string['noinvitationinstanceset'] = 'Nie znaleziono żadnego przypadku rejestracji zaproszenia. Proszę najpierw dodać instancję zaproszenia do swojego kursu.';
$string['nopermissiontosendinvitation'] = 'Brak uprawnień do wysyłania zaproszeń';
$string['norole'] = 'Wybierz rolę.';
$string['notify_inviter'] = 'Powiadom mnie na adres e-mail {$a->email}, gdy zaproszeni użytkownicy zaakceptują to zaproszenie.';
$string['header_role'] = 'Jaką rolę chcesz przypisać zaproszonemu?';
$string['email_clarification'] = 'Można podać wiele adresów e-mail, rozdzielając je średnikami, przecinkami, spacjami lub nowymi liniami.';
$string['subject'] = 'Temat';
$string['status'] = 'Dopuść zaproszenia';
$string['status_desc'] = 'Pozwól użytkownikom zapraszać ludzi do zapisania się na kurs domyślnie.';
$string['unenrol'] = 'Odwołaj zapisanie użytkownika';
$string['unenroluser'] = 'Naprawdę chcesz wypisać "{$a->użytkownik}" z kursu "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Naprawdę chcesz się wypisać się z kursu "{$a}"?';

// After invite sent strings.
$string['invitationsuccess'] = 'Zaproszenie zostało wysłane';
$string['revoke_invite_sucess'] = 'Invitation sucessfully revoked';
$string['extend_invite_sucess'] = 'Invitation sucessfully extended';
$string['resend_invite_sucess'] = 'Invitation sucessfully resent';
$string['returntocourse'] = 'Powrót do kursu';
$string['returntoinvite'] = 'Wyślij kolejne zaproszenie';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Invitation acceptance';
$string['expiredtoken'] = 'Invitation token is expired or has already been used.';
$string['loggedinnot'] = '<p>This invitation to access "{$a->coursefullname}" as a "{$a->rolename}" is intended for {$a->email}. If you are not the intended recipient, please do not accept this invitation.</p>
<p>Before you can accept this invitation you must be logged in.</p>';
$string['invitationacceptance'] = '<p>This invitation to access "{$a->coursefullname}" as a "{$a->rolename}" is intended for {$a->email}. If you are not the intended recipient, please do not accept this invitation.</p>';
$string['invitationacceptancebutton'] = 'Accept invitation';

// Invite history strings.
$string['invitehistory'] = 'Historia zaproszeń';
$string['noinvitehistory'] = 'Jeszcze nie wysłano żadnych zaproszeń';
$string['historyinvitee'] = 'Zaproszony';
$string['historyrole'] = 'Rola';
$string['historystatus'] = 'Status';
$string['historydatesent'] = 'Data wysłania';
$string['historydateexpiration'] = 'Data wygaśnięcia';
$string['historyactions'] = 'Akcje';
$string['historyundefinedrole'] = 'Nie można znaleźć roli. Proszę wyślij zaproszenie ponownie i wybierz inną rolę.';
$string['historyexpires_in'] = 'wygasa w ciągu';
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

// Strings for datetimehelpers.
$string['less_than_x_seconds'] = 'less than {$a} seconds';
$string['half_minute'] = 'half a minute';
$string['less_minute'] = 'less than a minute';
$string['a_minute'] = '1 minute';
$string['x_minutes'] = '{$a} minutes';
$string['about_hour'] = 'about 1 hour';
$string['about_x_hours'] = 'about {$a} hours';
$string['a_day'] = '1 day';
$string['x_days'] = '{$a} days';
$string['enrolconfimation'] = 'Is required confirmation of enrolment?';
$string['successenroled'] = 'You have been successfully enrolled to the course {$a}';
$string['close'] = 'Close';
$string['invitationrejectbutton'] = 'Reject invitation';
$string['event_invitation_rejected'] = 'Invitation Rejected';
$string['status_invite_rejected'] = 'Rejected';
$string['invtitation_rejected_notice'] = '<p>This invitation to access "{$a->coursefullname}" as a "{$a->rolename}" for yours account with email {$a->email} was rejected.';
