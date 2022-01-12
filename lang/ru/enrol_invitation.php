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
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['assignrole'] = 'Назначить роль';
$string['cannotsendmoreinvitationfortoday'] = 'Ни одного приглашения не было отправлено сегодня. Попробуйте зайти позже.';
$string['defaultinvitevalues'] = 'Default invitation values';
$string['defaultrole'] = 'Роль по умолчанию';
$string['defaultrole_desc'] = 'Выберите роль, которая должна быть назначена пользователю во время приглашения';
$string['editenrolment'] = 'Редактировать способ записи на курс';
// Obsolete $string['emailaddressnumber'] = 'Email  {$a}'; // .
$string['fromuserconfig'] = 'Default invitation from user';
$string['emailmessageinvitation'] = '{$a->managername} приглашает Вас присоединиться к курсу {$a->fullname}.

Для этого просто перейдите по данной ссылке: {$a->enrolurl}

Вам понадобится создать аккаунт или авторизоваться на сайте.

{$a->sitename}
-----------------------------
{$a->siteurl}';
$string['emailmessageuserenrolled'] = 'Здравствуйте,

    {$a->userfullname} ({$a->useremail}) принял(а) Ваше приглашение для доступа к курсу {$a->coursefullname} с ролью "{$a->rolename}". Вы можете проверить статус этого приглашения, просмотрев:

        - Список участников: {$a->courseenrolledusersurl}
        - Историю приглашений: {$a->invitehistoryurl}

    {$a->sitename}
    -------------
    {$a->supportemail}';

$string['emailssent'] = 'Письмо(а) были отосланы.';
$string['emailtitleinvitation'] = 'Вы были приглашены присоединиться к курсу {$a->fullname}.';
$string['emailtitleuserenrolled'] = '{$a->userfullname} принял(а) приглашение на  {$a->coursefullname}.';
$string['enrolenddate'] = 'Окончание даты';
$string['enrolenddate_help'] = 'Если доступно, то пользователи могут записаться только до этой даты.';
$string['enrolenddaterror'] = 'Дата окончания записи не может быть раньше даты начала записи на курс';
$string['enrolperiod'] = 'Продолжительность зачисления';
$string['enrolperiod_desc'] = 'Период времени по умолчанию, когда запись на курс будет доступна(в секундах). Если число равно 0, то период записи на курс будет неограничен.';
$string['enrolperiod_help'] = 'Период времени действии регистрации, начиная с момента регистрации пользователя. Если выключено, продолжительность регистрации будет неограниченной.';
$string['enrolstartdate'] = 'Дата начала';
$string['enrolstartdate_help'] = 'Если этот параметр включен, пользователи могут быть зачислены только с этой даты.';
$string['expiredtoken'] = 'Приглашение уже было использовано, или его срок действия истёк.';
$string['invitationpagehelp'] = '<ul><li>Сегодня было отослано {$a}.</li><li>Каждое приглашение может быть разослано только 1 раз.</li></ul>';
$string['inviteusers'] = 'Приглашенные пользователи';
$string['maxinviteerror'] = 'Должно быть число.';
$string['maxinviteperday'] = 'Максимум приглашений в день ';
$string['maxinviteperday_help'] = 'Максимум приглашений, который можно отправить в день для курса.';
$string['noinvitationinstanceset'] = 'Ни одного приглашения не было найдено. Пожалуйста, добавьте хотя бы одно приглашение.';
$string['nopermissiontosendinvitation'] = 'У вас нет прав на отправку приглашений';
$string['pluginname'] = 'Приглашение';
$string['pluginname_desc'] = 'Модуль Invitation (Приглашение) позволяет отправить пользователю приглашение по электронной почте. Эти приглашения могут быть использованы только один раз. Пользователи, нажав на ссылку электронной почты, автоматически зачисляются на курс.';
$string['status'] = 'Разрешить учащимся рассылать приглашения';
$string['status_desc'] = 'Разрешить по умолчанию пользователям приглашать людей записаться на курс.';
$string['unenrol'] = 'Исключенные пользователи';
$string['unenroluser'] = 'Вы действительно хотите исключить "{$a->user}" из курса "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Вы действительно хотите исключить себя из курса "{$a}"?';
$string['registeredonly'] = 'Send invitiation only for registered users';
$string['registeredonly_help'] = 'Invitation will be sent only to emails, which belongs to registered users.';
$string['reminder'] = 'Напоминание: ';
$string['usedefaultvalues'] = 'Use invitation with default values';
$string['emailmsgunsubscribe'] = '<span class=\"apple-link\">If you believe that you have received this message in error or are in need of assistance, please contact:</span><br>
<a href=\"mailto:{$a->supportemail}\">{$a->supportemail}</a>.';
$string['emailmsgtxt'] = 'Инструкции:
------------------------------------------------------------
Вас пригласили на курс: {$a->fullname}. Для получения доступа к сайту, вам нужно будет зарегистрироваться (если Вы не сделали этого раньше) и войти на сайт.
Имейте ввиду, что переходя по ссылке, предоставленной в этом письме:
- подтверждаете, что Вы тот(та), кому было адресовано это письмо и/или для кого оно было предназначено;
- срок действия ссылки, приведённой ниже, истечёт {$a->expiration}.

Ссылка для доступа:
------------------------------------------------------------
{$a->inviteurl}

Если Вы считаете, что получили это письмо по ошибке, или Вам нужна помощь, пожалуйста свяжитесь со службой поддержки сайта по адресу:  {$a->supportemail}.';
$string['instructormsg'] = 'Сообщение от инструктора:
------------------------------------------------------------
{$a}

';
$string['default_subject'] = 'Приглашение для {$a}';
$string['editenrollment'] = 'Редактировать запись на курс';
$string['header_email'] = 'Кого бы вы хотели пригласить?';
$string['emailaddressnumber'] = 'Адрес электронной почты';
$string['notifymsg'] = 'Здравствуйте, информируем Вас, что пользователь $a->username, с адресом электронной почты $a->email успешно получил доступ к Вашему курсу, $a->course';
$string['inviteexpiration'] = 'Истечение срока действия приглашения';
$string['inviteexpiration_desc'] = 'Длительность периода времени (в секундах) в течение которого приглашение будет действительно. По умолчанию - 2 недели.';
$string['show_from_email'] = 'Разрешить приглашённому пользователю связаться со мной по адресу {$a->email} (Ваш адрес будет использован в качестве адреса отправителя. Если не выбрано - в качестве адреса отправителя письма будет использован {$a->supportemail})';
$string['message'] = 'Сообщение';
$string['message_help_link'] = 'просмотреть какие инструкции били отправлены приглашённым';
$string['message_help'] = 'Инструкции:
<hr>
Вас пригласили на сайт: [site name]. Для получения доступа к сайту, вам нужно будет зарегистрироваться (если Вы не сделали этого раньше) и войти на сайт.
Имейте ввиду, что переходя по ссылке, предоставленной в этом письме:
- подтверждаете, что Вы тот(та), кому было адресовано это письмо и/или для кого оно было предназначено;
- срок действия ссылки, приведённой ниже, истечёт [expiration date].

Ссылка для доступа:<br>
<hr>
[invite url]<br><br>
Если Вы считаете, что получили это письмо по ошибке, или Вам нужна помощь, пожалуйста свяжитесь со службой поддержки сайта по адресу:  [support email].';
$string['norole'] = 'Пожалуйста, выберите роль.';
$string['notify_inviter'] = 'Сообщать мне по адресу {$a->email} когда приглашённые пользователи примут приглашение';
$string['header_role'] = 'Какую роль Вы хотели бы назначить приглашаемому?';
$string['email_clarification'] = 'Вы можете указать несколько адресов электронной почты, разделяя их точками с запятой, запятыми, пробелами или вводя каждый с новой строки';
$string['subject'] = 'Тема';

// After invite sent strings.
$string['invitationsuccess'] = 'Приглашение успешно отправлено';
$string['revoke_invite_sucess'] = 'Приглашение успешно отозвано';
$string['extend_invite_sucess'] = 'Приглашение успешно продлено';
$string['resend_invite_sucess'] = 'Приглашение успешно переслано';
$string['returntocourse'] = 'Вернуться к курсу';
$string['returntoinvite'] = 'Отправить ещё одно приглашение';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Подтверждение приёма приглашения';
$string['loggedinnot'] = '<p>Это приглашение для доступа к курсу "{$a->coursefullname}" с ролью "{$a->rolename}" предназначено для {$a->email}. Если Вы не тот, кому оно было предназначено, пожалуйста, не принимайте это приглашение</p>
<p>Перед тем, как Вы примете это приглашение вы должны зарегистрироваться и войти в систему.</p>';
$string['invitationacceptance'] = '<p>Это приглашение для доступа к курсу "{$a->coursefullname}" с ролью "{$a->rolename}" предназначено для {$a->email}. Если Вы не тот, кому оно было предназначено, пожалуйста, не принимайте это приглашение</p>';
$string['invitationacceptancebutton'] = 'Принять приглашение';

// Invite history strings.
$string['invitehistory'] = 'История приглашений';
$string['noinvitehistory'] = 'Ни одно приглашение ищё не отправлено';
$string['historyinvitee'] = 'Приглашённый';
$string['historyrole'] = 'Роль';
$string['historystatus'] = 'Состояние';
$string['historydatesent'] = 'Дата отправки';
$string['historydateexpiration'] = 'Окончание срока действия';
$string['historyactions'] = 'Действия';
$string['historyundefinedrole'] = 'Невозможно найти указанную роль. Пожалуйста, перешлите приглашение и выберете другую роль.';
$string['historyexpires_in'] = 'истекает через';
$string['used_by'] = ' {$a->username} ({$a->roles}, {$a->useremail}) on {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = 'Недействительно';
$string['status_invite_expired'] = 'Истекло';
$string['status_invite_used'] = 'Принято';
$string['status_invite_used_noaccess'] = '(более не имеет доступа)';
$string['status_invite_used_expiration'] = '(доступ заканчивается {$a})';
$string['status_invite_revoked'] = 'Отозвано';
$string['status_invite_resent'] = 'Переслано';
$string['status_invite_active'] = 'Активно';

// Invite action strings.
$string['action_revoke_invite'] = 'Отозвать приглашение';
$string['action_extend_invite'] = 'Продлить приглашение';
$string['action_resend_invite'] = 'Переслать приглашение';

// Capabilities strings.
$string['invitation:config'] = 'Настройка приглашений';
$string['invitation:enrol'] = 'Пригласить пользователей';
$string['invitation:manage'] = 'Управление приглашениями';
$string['invitation:unenrol'] = 'Отчислять пользователей из курса';
$string['invitation:unenrolself'] = 'Отчислить себя из курса';

// Strings for datetimehelpers.
$string['less_than_x_seconds'] = 'менее {$a} секунд';
$string['half_minute'] = 'пол-минуты';
$string['less_minute'] = 'меньше минуты';
$string['a_minute'] = '1 минута';
$string['x_minutes'] = '{$a} минут';
$string['about_hour'] = 'около часа';
$string['about_x_hours'] = 'около {$a} часов';
$string['a_day'] = '1 день';
$string['x_days'] = '{$a} дней';
$string['enrolconfimation'] = 'Is required confirmation of enrolment?';
$string['successenroled'] = 'You have been successfully enrolled to the course {$a}';
$string['close'] = 'Close';
$string['invitationrejectbutton'] = 'Reject invitation';
$string['event_invitation_rejected'] = 'Invitation Rejected';
$string['status_invite_rejected'] = 'Rejected';
$string['invtitation_rejected_notice'] = '<p>This invitation to access "{$a->coursefullname}" as a "{$a->rolename}" for yours account with email {$a->email} was rejected.';
