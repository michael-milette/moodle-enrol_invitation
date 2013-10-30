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
 * Event registration .
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$handlers = array(
    // Add site invitation plugin when courses are created. Note that only
    // managers can manage/configure enrollment plugin, so we need to add it
    // automatically for instructors. Instructors can hide or delete plugin.
    'course_created' => array(
        'handlerfile'     => '/enrol/invitation/eventslib.php',
        'handlerfunction' => 'add_site_invitation_plugin',
        'schedule'        => 'instant'
    ),
    'course_restored' => array (
         'handlerfile'      => '/enrol/invitation/eventslib.php',
         'handlerfunction'  => 'add_site_invitation_plugin',
         'schedule'         => 'instant'
     ),
);