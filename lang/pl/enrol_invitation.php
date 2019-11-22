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
$string['pluginname'] = 'Zaproszenie';
$string['pluginname_desc'] = 'Moduł Zaproszenie umożliwia wysyłanie zaproszeń pocztą elektroniczną. Zaproszenia te mogą być użyte tylko raz. Użytkownicy klikający na link e-mail są automatycznie rejestrowani.';

// Email message strings.
$string['reminder'] = 'Przypomnienie: ';

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
$string['defaultrole_desc'] = 'Wybierz rolę, która powinna być przypisana użytkownikom podczas rejestracji zaproszeń.';
$string['default_subject'] = 'Zaproszenie na kurs {$a}';
$string['editenrollment'] = 'Edycja zapisów';
$string['header_email'] = 'Kogo chcesz zaprosić?';
$string['email'] = 'Adresy e-mail';
$string['emailaddressnumber'] = 'Adresy e-mail';

$string['notifymsg'] = 'Witam, chciałbym poinformować, że użytkownik $a->username, z e-mailem $a->email zaakceptował dostęp do twojego kursu, $a->course';

$string['emailtitleuserenrolled'] = '{$a->userfullname} zaakceptował zaproszenie do {$a->coursefullname}.';
$string['emailmessageuserenrolled'] = 'Witam,

    {$a->userfullname} ({$a->useremail}) zaakceptował twoje zaproszenie do kursu {$a->coursefullname} jako a "{$a->rolename}". Status tego zaproszenia można sprawdzić, oglądając:

        * Listę uczestników: {$a->courseenrolledusersurl}
        * Historię zaproszeń: {$a->invitehistoryurl}

    {$a->sitename}
    -------------
    {$a->supportemail}';

$string['enrolenddate'] = 'Data końca dostępu';
$string['enrolenddate_help'] = 'Jeśli opcja ta zostanie włączona, będzie to data, po której zaproszony nie będzie mógł uzyskać dostępu do strony.';
$string['enrolenddaterror'] = 'Data zakończenia dostępu nie może być wcześniejsza niż dzisiaj.';
$string['enrolperiod'] = 'czas trwania rejestracji';
$string['enrolperiod_desc'] = 'Domyślny czas ważności rejestracji (w sekundach). Jeśli ustawione na zero, czas trwania rejestracji będzie domyślnie nieograniczony.';
$string['enrolperiod_help'] = 'Długość czasu, przez jaki obowiązuje rejestracja, począwszy od momentu rejestracji użytkownika. Jeśli opcja jest wyłączona, czas trwania rejestracji będzie nieograniczony.';
$string['enrolstartdate'] = 'Data początku';
$string['enrolstartdate_help'] = 'Jeśli opcja ta jest włączona, użytkownicy mogą być rejestrowani tylko od tej daty.';
$string['editenrolment'] = 'Edycja rejestracji';
$string['inviteexpiration'] = 'Wygaśnięcie zaproszenia';
$string['inviteexpiration_desc'] = 'Czas ważności zaproszenia (w sekundach). Domyślnie jest to 2 tygodnie.';

$string['show_from_email'] = 'Pozwól zaproszonemu użytkownikowi skontaktować się ze mną pod adresem {$a->email} (Twój adres będzie w polu "FROM". Jeśli nie zaznaczono tego pola, w polu "FROM" będzie {$a->supportemail})';
$string['inviteusers'] = 'Zaproś użytkownika';
$string['maxinviteerror'] = 'To musi być numer.';
$string['maxinviteperday'] = 'Maksymalna liczba zaproszeń na dzień';
$string['maxinviteperday_help'] = 'Maksymalna liczba zaproszeń do kursu, które można wysłać dziennie.';
$string['message'] = 'Wiadomość';

$string['message_help_link'] = 'sprawdź, jakie instrukcje są wysyłane w zaproszeniach.';
$string['message_help'] =
    '<h2>Dostęp do szkolenia:</h2>' .
    '<hr />' . 
    'Zostałeś/aś zaproszony/a do udziału w szkoleniu: [site name]. Musisz kliknąć poniższy link, aby zaakceptować udział w szkoleniu. <br />' .
    '<b>LINK DOSTĘPOWY:</b> ' . '[invite url] <br />' . 
    'Klikając na link dostępu do strony zamieszczony w tym e-mailu przyjmujesz do wiadomości, że: <br />' .
    '* jesteś osobą, do której adresowany był ten e-mail i dla której to zaproszenie jest przeznaczone;<br />' . 
    '* powyższy link wygaśnie w dniu ([expiration date]).' .
    '<p>Jeśli uważasz, że otrzymałeś tę wiadomość błędnie lub potrzebujesz pomocy, prosimy o kontakt: [support email].</p>';

$string['noinvitationinstanceset'] = 'Nie znaleziono żadnego przypadku rejestracji zaproszenia. Proszę najpierw dodać instancję zaproszenia do swojego kursu.';
$string['nopermissiontosendinvitation'] = 'Brak uprawnień do wysyłania zaproszeń';
$string['norole'] = 'Wybierz rolę.';
$string['notify_inviter'] = 'Powiadom mnie na adres e-mail {$a->email}, gdy zaproszeni użytkownicy zaakceptują to zaproszenie.';
$string['header_role'] = 'Jaką rolę chcesz przypisać zaproszonemu?';
$string['email_help'] = 'Można podać wiele adresów e-mail, rozdzielając je średnikami, przecinkami, spacjami lub nowymi liniami.';

$string['subject'] = 'Temat';
$string['extendedsubject'] = ' - Uczestnik szkolenia ';
$string['status'] = 'Dopuść zaproszenia';
$string['status_desc'] = 'Pozwól użytkownikom zapraszać ludzi do zapisania się na kurs domyślnie.';
$string['unenrol'] = 'Odwołaj zapisanie użytkownika';
$string['unenroluser'] = 'Naprawdę chcesz wypisać "{$a->użytkownik}" z kursu "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Naprawdę chcesz się wypisać się z kursu "{$a}"?';

// After invite sent strings.
$string['invitationsuccess'] = 'Zaproszenie zostało wysłane';
$string['revoke_invite_sucess'] = 'Zaproszenie zostało pomyślnie wycofane';
$string['extend_invite_sucess'] = 'Zaproszenie zostało pomyślnie przedłużone';
$string['resend_invite_sucess'] = 'Zaproszenie zostało pomyślnie wysłane';
$string['remove_invite_success'] = 'Zaproszenie zostało pomyślnie usunięte';
$string['remove_invite_confirm'] = 'Potwierdź usunięcie danych';
$string['returntocourse'] = 'Powrót do kursu';
$string['returntoinvite'] = 'Wyślij kolejne zaproszenie';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Przyjęcie zaproszenia';
$string['expiredtoken'] = 'Token zaproszenia wygasł lub został już użyty.';
$string['loggedinnot'] = '<p>To zaproszenie do dostępu do "{$a->coursefullname}" jako
    "{$a->rolename}" jest przeznaczone dla {$a->email}. Jeśli nie jesteś jego odbiorcą, nie przyjmuj tego zaproszenia. </p>
    <p>
        Zanim przyjmiesz to zaproszenie, musisz być zalogowany.
    </p>';
$string['invitationacceptance'] = '<p>To zaproszenie do dostępu do "{$a->coursefullname}" jako
    "{$a->rolename}" jest przeznaczone dla {$a->email}. Jeśli nie jesteś jego odbiorcą, nie przyjmuj tego zaproszenia. </p>';
$string['invitationacceptancebutton'] = 'Zaakceptuj zaproszenie';

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
$string['used_by'] = ' przez {$a->username} ({$a->roles}, {$a->useremail}) dnia {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = 'Nieprawidłowy';
$string['status_invite_expired'] = 'Wygasło';
$string['status_invite_used'] = 'Zaakceptowane';
$string['status_invite_used_noaccess'] = '(nie ma już dostępu)';
$string['status_invite_used_expiration'] = '(dostęp kończy się {$a})';
$string['status_invite_revoked'] = 'Wycofane';
$string['status_invite_resent'] = 'Powtórnie wysłane';
$string['status_invite_active'] = 'Aktywne';

// Invite action strings.
$string['action_revoke_invite'] = 'Wycofaj zaproszenie';
$string['action_extend_invite'] = 'Wyślij przypomnienie';
$string['action_resend_invite'] = 'Powtórnie wyślij zaproszenie';
$string['action_delete_invite'] = 'Usuń zaproszenie z bazy';

// Capabilities strings.
$string['invitation:config'] = 'Konfiguracja instancji zaproszeń';
$string['invitation:enrol'] = 'Zaproś użytkowników';
$string['invitation:manage'] = 'Zarządzanie przydziałami zaproszeń';
$string['invitation:unenrol'] = 'Usuwanie użytkowników z kursu.';
$string['invitation:unenrolself'] = 'Usuwanie siebie z kursu.';

// Strings for datetimehelpers.
$string['less_than_x_seconds'] = 'mniej niż {$a} sekund';
$string['half_minute'] = 'pół minuty';
$string['less_minute'] = 'poniżej minuty';
$string['a_minute'] = '1 minuta';
$string['x_minutes'] = '{$a} minut';
$string['about_hour'] = 'około 1 godziny';
$string['about_x_hours'] = 'około {$a} godzin';
$string['a_day'] = '1 dzień';
$string['x_days'] = '{$a} dni';