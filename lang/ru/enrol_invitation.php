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

$string['assignrole'] = 'Назначить роль';
$string['cannotsendmoreinvitationfortoday'] = 'Ни одного приглашения не было отправлено сегодня. Попробуйте зайти позже.';
$string['defaultrole'] = 'Роль по умолчанию';
$string['defaultrole_desc'] = 'Выберите роль, которая должна быть назначена пользователю во время приглашения';
$string['editenrolment'] = 'Редактировать метод записи Edit enrolment';
$string['emailaddressnumber'] = 'Email  {$a}';
$string['emailmessageinvitation'] = '{$a->managername} приглашает Вас присоединиться к курсу {$a->fullname}.

Для этого просто перейдите по данной ссылке: {$a->enrolurl}

Вам понадобиться создать аккаунт или авторизоваться на сайте.

{$a->sitename}
-----------------------------
{$a->siteurl}';
$string['emailmessageuserenrolled'] = '{$a->userfullname} записался на курс {$a->coursefullname}.

перейдите по ссылке, чтобы проверить новую запись: {$a->courseenrolledusersurl}

{$a->sitename}
-------------
{$a->siteurl}';
$string['emailssent'] = 'Email(ы) были отосланы.';
$string['emailtitleinvitation'] = 'Вы были приглашены присоединиться к курсу {$a->fullname}.';
$string['emailtitleuserenrolled'] = '{$a->userfullname} записался на  {$a->coursefullname}.';
$string['enrolenddate'] = 'Окончание даты';
$string['enrolenddate_help'] = 'Если доступно, то пользователи могут записаться только до этой даты.';
$string['enrolenddaterror'] = 'Дата окончания записи не может быть раньше даты начала записи на курс';
$string['enrolperiod'] = 'Продолжительность зачисления';
$string['enrolperiod_desc'] = 'Период времени по умолчанию, когда запись на курс будет доступна(в секундах). Если число равно 0, то период записи на курс будет неограничен.';
$string['enrolperiod_help'] = 'Период времени действии регистрации, начиная с момента регистрации пользователя. Если выключено, продолжительность регистрации будет неограниченной.';
$string['enrolstartdate'] = 'Дата начала';
$string['enrolstartdate_help'] = 'Если этот параметр включен, пользователи могут быть зачислены только с этой даты.';
$string['expiredtoken'] = 'Недопустимый параметр - процесс регистрации остановлен.';
$string['invitationpagehelp'] = '<ul><li>Сегодня было отослано {$a}.</li><li>Каждое приглашение может быть разослано только 1 раз.</li></ul>';
$string['inviteusers'] = 'Приглашенные пользователи';
$string['maxinviteerror'] = 'Должно быть число.';
$string['maxinviteperday'] = 'Максимум приглашений в день ';
$string['maxinviteperday_help'] = 'Максимум приглашений, который можно отправить в день для курса.';
$string['noinvitationinstanceset'] = 'Ни одного приглашения не было найдено. Пожалуйста, добавьте хотя бы одно приглашение.';
$string['nopermissiontosendinvitation'] = 'У вас нет прав на отправку приглашений';
$string['pluginname'] = 'Invitation';
$string['pluginname_desc'] = 'Модуль Invitation (Приглашение) позволяет отправить пользователю приглашение по электронной почте. Эти приглашения могут быть использованы только один раз. Пользователи, нажав на ссылку электронной почты, автоматически зачисляются на курс.';
$string['status'] = 'Разрешить учащимся рассылать приглашения';
$string['status_desc'] = 'Разрешить по умолчанию пользователям приглашать людей записаться на курс.';
$string['unenrol'] = 'Исключенные пользователи';
$string['unenroluser'] = 'Вы действительно хотите исключить "{$a->user}" из курса "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Вы действительно хотите исключить себя из курса "{$a}"?';
