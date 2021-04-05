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
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol
 * @subpackage invitation
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['assignrole'] = 'Toegekende rol';
$string['cannotsendmoreinvitationfortoday'] = 'De uitnodigingen zijn op voor vandaag, probeer het morgen.';
$string['defaultinvitevalues'] = 'Default invitation values';
$string['defaultrole'] = 'Standaard toegekende rol';
$string['defaultrole_desc'] = 'Selecteer de rol die toegekend moet worden aan gebruikers tijdens de aanmelding op uitnodiging';
$string['editenrolment'] = 'Bewerk aanmelding';
$string['emailaddressnumber'] = 'Email adres {$a}';
$string['emailmessageinvitation'] = '{$a->managername} heeft je uitgenodigd om deel te nemen aan {$a->fullname}. 

Log in op {$a->siteurl} en gebruik daarna deze link: {$a->enrolurl}

Als je nog geen login hebt kun je deze zelf aanmaken.

{$a->sitename}
-----------------------------';
$string['emailmessageuserenrolled'] = '{$a->userfullname} heeft zich aangemeld voor {$a->coursefullname}.
    
Volg deze snelkoppeling om de nieuwe aanmeldingen te bekijken: {$a->courseenrolledusersurl}

{$a->sitename}
-------------
{$a->siteurl}';
$string['emailssent'] = 'Email(s) verstuurd.';
$string['emailtitleinvitation'] = 'Je bent uitgenodigd om deel te nemen aan {$a->fullname}.';
$string['emailtitleuserenrolled'] = '{$a->userfullname} heeft zich aangemeld voor {$a->coursefullname}.';
$string['enrolenddate'] = 'Einddatum';
$string['enrolenddate_help'] = 'Indien geactiveerd kunnen gebruikers zich tot deze datum aanmelden.';
$string['enrolenddaterror'] = 'De einddatum voor aanmelding kan niet eerder zijn dan de begindatum';
$string['enrolperiod'] = 'Aanmeldingsduur';
$string['enrolperiod_desc'] = 'Standaard tijd voor geldigheidsduur van de aanmelding in seconden. Als deze op nul ingesteld is, geldt een oneindige geldigheidsduur.';
$string['enrolperiod_help'] = 'Geldigheidsduur van de aanmelding, gerekend vanaf het moment van aanmelden. Indien uitgeschakeld is de geldigheidsduur oneindig.';
$string['enrolstartdate'] = 'Begindatum';
$string['enrolstartdate_help'] = 'Indien ingeschakeld kunnen gebruikers pas vanaf deze datum aangemeld worden.';
$string['expiredtoken'] = 'Ongeldige toegangscode - de aanmeldingsprocedure is beëindigd.';
$string['invitationpagehelp'] = '<ul><li>U heeft vandaag nog {$a} uitnodiging(en) over.</li><li>Elke uitnodiging is uniek en verliest haar geldigheid na eenmalig gebruik.</li></ul>';
$string['inviteusers'] = 'Nodig gebruikers uit';
$string['maxinviteerror'] = 'Het moet een getal zijn.';
$string['maxinviteperday'] = 'Maximum aantal uitnodigingen per dag';
$string['maxinviteperday_help'] = 'Maximum aantal uitnodingen per dag voor deze cursus.';
$string['noinvitationinstanceset'] = 'Voor deze cursus is nog geen uitnodigingsprocedure geactiveerd. Voeg de procedure toe in Cursusbeheer/Gebruikers/Aanmeldingsmethodes.';
$string['nopermissiontosendinvitation'] = 'Geen toestemming om uitnodigingen te versturen';
$string['pluginname'] = 'Uitnodiging';
$string['pluginname_desc'] = 'Met de uitnodigingsmodule kunt u uitnodigingen per email versturen. Deze uitnodingen zijn eenmalig geldig. Ingelogde gebruikers die vervolgens op de ontvangen link klikken worden automatisch aangemeld voor de betreffende cursus.';
$string['status'] = 'Sta aanmeldingen op uitnodiging toe';
$string['status_desc'] = 'Sta docenten standaard toe om gebruikers uit te nodigen zich aan te melden voor een cursus.';
$string['unenrol'] = 'Meld de gebruiker af';
$string['unenroluser'] = 'Wilt u "{$a->user}" inderdaad afmelden voor de cursus "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Wilt u zich inderdaad afmelden voor de cursus "{$a}"?';
$string['registeredonly'] = 'Send invitiation only for registered users';
$string['registeredonly_help'] = 'Invitation will be sent only to emails, which belongs to registered users.';
$string['usedefaultvalues'] = 'Use invitation with default values';
$string['emailmsgunsubscribe'] ='<span class=\"apple-link\">If you believe that you have received this message in error or are in need of
                                               assistance, please contact:</span>
                    <br><a href=\"mailto:{$a->supportemail}\">{$a->supportemail}</a>.';