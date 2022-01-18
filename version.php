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
 * Version information for Invitation.
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version  = 2022011802;
$plugin->requires = 2013111800;   // Moodle 3.9 is required.
$plugin->maturity = MATURITY_BETA;
$plugin->release   = '2.0.0';
$plugin->component = "enrol_invitation";
