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
 * Always include formslib
 */
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}


require_once ('locallib.php');
require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/lib/enrollib.php');

/**
 * The mform class for sending invitation to enrol users in a course
 *
 * @copyright 2011 Jerome Mouneyrac
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package enrol
 * @subpackage invitation
 */
class invitations_form extends moodleform {

    /**
     * The form definition
     */
    function definition() {
        global $CFG, $USER, $OUTPUT, $PAGE;
        $mform = & $this->_form;

        // Add some hidden fields
        $courseid = $this->_customdata['courseid']; 
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $courseid);
        $invitationleft = $this->_customdata['leftinvitation']; 
        
        // Email address fields
        for ($i = 1; $i <= $invitationleft; $i += 1) {
            $mform->addElement('text', 'email' . $i, get_string('emailaddressnumber', 'enrol_invitation', $i), 'size="50"');
            if ($i == 1) {
                //first email address is required
                $mform->addRule('email'.$i, get_string('required'), 'required');
            }
            $mform->setType('email'.$i, PARAM_EMAIL);
        }

        if ($invitationleft > 0) {
            $this->add_action_buttons(false, get_string('inviteusers', 'enrol_invitation'));
        }
    }

}
