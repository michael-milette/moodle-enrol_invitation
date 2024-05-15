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
 * @copyright  2021-2023 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Phillip Fickl
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Global strings.
$string['pluginname'] = 'Einladung';
$string['pluginname_desc'] = 'Das Einladungsmodul ermöglicht das Versenden von Einladungen per E-Mail. Diese Einladungen können nur einmal verwendet werden. Nutzer/innen, die auf den E-Mail-Link klicken, werden automatisch eingeschrieben.';

// Logging strings.
$string['event_invitation_accepted'] = 'Akzeptieren';
$string['event_invitation_attempted'] = 'Versuch';
$string['event_invitation_deleted'] = 'Gelöscht';
$string['event_invitation_sent'] = 'Senden';
$string['event_invitation_updated'] = 'Aktualisiert';
$string['event_invitation_viewed'] = 'Angesehen';
$string['event_invitation_rejected'] = 'Ablehnung';

// Email message strings.
$string['reminder'] = 'Erinnerung: ';

$string['emailmsghtml'] = 'Vorschau';
$string['emailmsghtml_help'] = '<p>Guten Tag,</p>
<p>Sie sind eingeladen, dem folgenden Kurs beizutreten:</p>
<ul>
  <li>Kursname: <b>{$a->coursename}</b></li>
  <li>Startdatum: <b>{$a->start}</b></li>
  <li>Enddatum: <b>{$a->end}</b></li>
</ul>
{$a->message}
<p>Melden Sie sich an, um Ihre Einschreibung im Kurs zu bestätigen.</p>
<p>Durch die Verwendung dieses Links bestätigen Sie, dass Sie die Person sind, an die diese E-Mail gerichtet war und für die diese Einladung bestimmt ist.</p>
<p><a class="btn btn-primary" href="{$a->inviteurl}">{$a->acceptinvitation}</a></p>
<p>Falls Sie nicht an diesem Kurs teilnehmen möchten, verwenden Sie bitte den folgenden Link:</p>
<p><a class="btn btn-danger" href="{$a->rejecturl}">{$a->rejectinvitation}</a></p>
<p>Beachten Sie, dass diese Links am <b>{$a->expiration}</b> ablaufen.</p>
<p>Wir hoffen, Sie im Kurs zu sehen.</p>
';

$string['noenddate'] = 'Kein Enddatum';

$string['emailmsgunsubscribe'] = '<span class="apple-link">Wenn Sie glauben, dass Sie diese Nachricht irrtümlich erhalten haben, Hilfe benötigen oder keine weiteren Einladungen für diesen Kurs erhalten möchten, wenden Sie sich bitte an:</span> <a href="mailto:{$a->supportemail}">{$a->supportemail}</a>.';

// Invite form strings.
$string['assignrole'] = 'Rolle zuweisen';
$string['defaultinvitevalues'] = 'Standardeinladungswerte';
$string['usedefaultvalues'] = 'Einladung mit Standardwerten verwenden';
$string['default_subject'] = 'Kurseinladung: {$a}';
$string['header_email'] = 'Wen möchten Sie einladen?';
$string['emailaddressnumber'] = 'E-Mail-Adresse';
$string['err_userlist'] = 'Oder wählen Sie hier Nutzer/innen aus.';
$string['err_cohortlist'] = 'Oder wählen Sie hier Kohorten aus.';

$string['emailtitleuserenrolled'] = '{$a->userfullname} hat die Einladung zu {$a->coursefullname} angenommen.';
$string['emailmessageuserenrolled'] = 'Hallo,

{$a->userfullname} ({$a->useremail}) hat Ihre Einladung zum Zugriff auf {$a->coursefullname} als "{$a->rolename}" angenommen. Sie können den Status dieser Einladung überprüfen, indem Sie entweder die Teilnehmerliste oder die Einladungshistorie anzeigen:

    Teilnehmerliste: {$a->courseenrolledusersurl}
    Einladungshistorie: {$a->invitehistoryurl}

{$a->sitename}
-------------
{$a->supportemail}';

$string['editenrolment'] = 'Einschreibung bearbeiten';
$string['inviteexpiration'] = 'Einladung Ablaufzeit';
$string['inviteexpiration_desc'] = 'Dauer, für die eine Einladung gültig ist (in Sekunden). Standard ist 2 Wochen.';

$string['show_from_email'] = 'Erlaube dem/der eingeladenen Nutzer/in, mich unter {$a->email} zu kontaktieren (Ihre Adresse wird im "FROM"-Feld stehen. Wenn nicht ausgewählt, wird das "FROM"-Feld {$a->supportemail} sein)';
$string['inviteusers'] = 'Nutzer/innen einladen';
$string['message'] = 'Nachricht';
$string['message_help_link'] = 'Informationen anzeigen, die Eingeladenen erhalten';
$string['noinvitationinstanceset'] = 'Keine Einladungs-Enroll-Instanz gefunden. Bitte fügen Sie zuerst eine Einladungs-Enroll-Instanz zu Ihrem Kurs hinzu.';
$string['nopermissiontosendinvitation'] = 'Keine Berechtigung zum Senden der Einladung';
$string['norole'] = 'Bitte wählen Sie eine Rolle aus.';
$string['notify_inviter'] = 'Benachrichtige mich bei {$a->email}, wenn eingeladene Nutzer/innen diese Einladung annehmen';
$string['registeredonly'] = 'Sende Einladung nur an registrierte Nutzer/innen';
$string['registeredonly_help'] = 'Einladung wird nur an E-Mails gesendet, die zu registrierten Nutzer/innen gehören.';
$string['header_role'] = 'Welche Rolle möchten Sie dem Eingeladenen zuweisen?';
$string['email_clarification'] = 'Sie können mehrere E-Mail-Adressen angeben, indem Sie diese mit Semikolon, Komma, Leerzeichen oder Zeilenumbrüchen trennen';
$string['subject'] = 'Betreff';
$string['status'] = 'Einladungen erlauben';
$string['status_desc'] = 'Nutzer/innen standardmäßig erlauben, Leute einzuladen, um an einem Kurs teilzunehmen.';
$string['unenrol'] = 'Nutzer/in abmelden';
$string['unenroluser'] = 'Möchten Sie "{$a->user}" wirklich von dem Kurs "{$a->course}" abmelden?';
$string['enrolconfimation'] = 'Bestätigung der Einschreibung durch den Schüler erforderlich';
$string['defaultsubjectformat'] = 'Standard-Betreffformat';
$string['defaultsubjectformat_desc'] = 'Dies ist das Standardkursnamensformat, das in der Betreffzeile verwendet wird, wenn Einladungen per E-Mail versendet werden. Beachten Sie, dass dies nur die Instanzen der Anmeldemethode betrifft, wenn sie zum ersten Mal erstellt werden. Wenn Sie <strong>Custom Format</strong> auswählen, können Sie die Sprachzeichenfolge <strong>customsubjectformat</strong> des <strong>enrol_invitation</strong>-Plugins mit einer Kombination aus Kurz- und/oder Langnamen anpassen. <a href="../admin/tool/customlang/">Hier</a>. Wenn dieses Plugin zum ersten Mal installiert wird, ist das benutzerdefinierte Format auf "shortname - fullname" eingestellt.';
$string['customnamecourse'] = 'Custom-Format';
$string['customsubjectformat'] = '{$a->shortname} - {$a->fullname}';

// After invite sent strings.
$string['invitationrejected'] = 'Einladung abgelehnt';
$string['invitationsuccess'] = 'Einladung erfolgreich versendet';
$string['revoke_invite_sucess'] = 'Einladung erfolgreich widerrufen';
$string['extend_invite_sucess'] = 'Einladung erfolgreich verlängert';
$string['resend_invite_sucess'] = 'Einladung erfolgreich erneut versendet';
$string['returntocourse'] = 'Zurück zum Kurs';
$string['returntoinvite'] = 'Senden Sie eine weitere Einladung';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Einladungsbestätigung';
$string['expiredtoken'] = 'Der Einladungs-Token ist abgelaufen oder wurde bereits verwendet.';
$string['usernotmatch'] = '<p>Die Einladung ist für eine/n anderen Nutzer/in bestimmt.</p>';
$string['loggedinnot'] = '<p>Sie müssen sich anmelden, bevor Sie diese Einladung akzeptieren können.</p>';
$string['invtitation_rejected_notice'] = '<p>Diese Einladung wurde abgelehnt.</p>';
$string['invitationacceptance'] = '<p>Sie sind eingeladen, auf <strong>{$a->coursefullname}</strong> als <strong>{$a->rolename}</strong> zuzugreifen. Bitte bestätigen Sie Ihre Annahme, um an diesem Kurs teilzunehmen.</p>';
$string['invitationacceptancebutton'] = 'Einladung akzeptieren';
$string['invitationrejectbutton'] = 'Einladung ablehnen';

// Invite history strings.
$string['invitehistory'] = 'Einladungsverlauf';
$string['noinvitehistory'] = 'Noch keine Einladungen versendet';
$string['historyinvitee'] = 'Eingeladener';
$string['historyrole'] = 'Rolle';
$string['historystatus'] = 'Status';
$string['historydatesent'] = 'Versendet am';
$string['historydateexpiration'] = 'Ablaufdatum';
$string['historyactions'] = 'Aktionen';
$string['historyundefinedrole'] = 'Rolle kann nicht gefunden werden. Bitte Einladung erneut versenden und eine andere Rolle auswählen.';
$string['historyexpires_in'] = 'läuft ab in';
$string['used_by'] = ' von {$a->username} ({$a->roles}, {$a->useremail}) am {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = 'Ungültig';
$string['status_invite_expired'] = 'Abgelaufen';
$string['status_invite_used'] = 'Akzeptiert';
$string['status_invite_used_noaccess'] = '(kein Zugriff mehr)';
$string['status_invite_used_expiration'] = '(Zugriff endet am {$a})';
$string['status_invite_revoked'] = 'Zurückgezogen';
$string['status_invite_resent'] = 'Erneut gesendet';
$string['status_invite_active'] = 'Aktiv';
$string['status_invite_rejected'] = 'Abgelehnt';

// Invite action strings.
$string['action_revoke_invite'] = 'Einladung zurückziehen';
$string['action_extend_invite'] = 'Einladung verlängern';
$string['action_resend_invite'] = 'Einladung erneut senden';

// Capabilities strings.
$string['invitation:config'] = 'Einladungsinstanzen konfigurieren';
$string['invitation:enrol'] = 'Nutzer/in einladen';
$string['invitation:manage'] = 'Einladungszuweisungen verwalten';
$string['invitation:unenrol'] = 'Nutzer/in von dem Kurs abmelden';
$string['invitation:unenrolself'] = 'Sich selbst von dem Kurs abmelden';

// Strings for datetime helpers.
$string['less_than_x_seconds'] = 'weniger als {$a} Sekunden';
$string['half_minute'] = 'eine halbe Minute';
$string['less_minute'] = 'weniger als eine Minute';
$string['a_minute'] = '1 Minute';
$string['x_minutes'] = '{$a} Minuten';
$string['about_hour'] = 'etwa 1 Stunde';
$string['about_x_hours'] = 'etwa {$a} Stunden';
$string['a_day'] = '1 Tag';
$string['x_days'] = '{$a} Tage';

// Strings for Moodle logs.
$string['anonymoususer'] = '(unbekannt)';
$string['failuredescription'] = "Fehler: Benutzer ID {$a->userid}, Kurs ID '{$a->courseid}'. Grund: {$a->errormsg}.";
$string['accepteddescription'] = "Benutzer ID {$a->userid} hat eine Einladung für den Kurs mit der ID '{$a->courseid}' akzeptiert.";
$string['rejecteddescription'] = "Benutzer ID {$a->userid} hat eine Einladung für den Kurs mit der ID '{$a->courseid}' abgelehnt.";
$string['deleteddescription'] = "Benutzer ID {$a->userid} hat eine Einladung für den Kurs mit der ID '{$a->courseid}' an die E-Mail-Adresse '{$a->email}' gelöscht.";
$string['notsentdescription'] = "Benutzer ID {a->userid} konnte keine Einladung für den Kurs mit der ID '{$a->courseid}' senden, da kein Konto mit der E-Mail-Adresse '{$a->email}' vorhanden ist.";
$string['sentdescription'] = "Benutzer ID {$a->userid} hat eine Einladung für den Kurs mit der ID '{$a->courseid}' an die E-Mail-Adresse '{$a->email}' gesendet.";
$string['updateddescription'] = "Benutzer ID {$a->userid} hat die Einladung für den Kurs ID '{$a->courseid}' an die E-Mail-Adresse '{$a->email}' verlängert.";
$string['vieweddescription'] = "Benutzer ID {$a->userid} hat die Einladung für den Kurs mit der ID '{$a->courseid}' angesehen.";
