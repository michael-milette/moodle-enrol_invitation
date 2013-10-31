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
 * Form to display invitation.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once('locallib.php');
require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/lib/enrollib.php');

/**
 * Class for sending invitation to enrol users in a course.
 *
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class invitation_form extends moodleform {
    /**
     * The form definition.
     */
    public function definition() {
        global $CFG, $DB, $USER;
        $mform = & $this->_form;

        // Get rid of "Collapse all" in Moodle 2.5+.
        if (method_exists($mform, 'setDisableShortforms')) {
            $mform->setDisableShortforms(true);
        }

        // Add some hidden fields.
        $course = $this->_customdata['course'];
        $prefilled = $this->_customdata['prefilled'];
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $course->id);

        // Set roles.
        $mform->addElement('header', 'header_role', get_string('header_role', 'enrol_invitation'));

        $site_roles = $this->get_appropiate_roles($course);
        $label = get_string('assignrole', 'enrol_invitation');
        $role_group = array();
        foreach ($site_roles as $role_type => $roles) {
            $role_type_string = html_writer::tag('div',
                    get_string('archetype'.$role_type, 'role'),
                    array('class' => 'label badge-info'));
            $role_group[] = &$mform->createElement('static', 'role_type_header',
                    '', $role_type_string);

            foreach ($roles as $role) {
                $role_string = $this->format_role_string($role);
                $role_group[] = &$mform->createElement('radio', 'roleid', '',
                        $role_string, $role->id);
            }
        }

        $mform->addGroup($role_group, 'role_group', $label);
        $mform->addRule('role_group',
                get_string('norole', 'enrol_invitation'), 'required');

        // Email address field.
        $mform->addElement('header', 'header_email', get_string('header_email', 'enrol_invitation'));
        $mform->addElement('textarea', 'email', get_string('emailaddressnumber', 'enrol_invitation'),
                array('maxlength' => 1000, 'class' => 'form-invite-email'));
        $mform->addRule('email', null, 'required', null, 'client');
        $mform->setType('email', PARAM_TEXT);
        // Check for correct email formating later in validation() function.
        $mform->addElement('static', 'email_clarification', '', get_string('email_clarification', 'enrol_invitation'));

        // Ssubject field.
        $mform->addElement('text', 'subject', get_string('subject', 'enrol_invitation'),
                array('class' => 'form-invite-subject'));
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', get_string('required'), 'required');
        // Default subject is "Site invitation for <course title>".
        $default_subject = get_string('default_subject', 'enrol_invitation',
                sprintf('%s: %s', $course->shortname, $course->fullname));
        $mform->setDefault('subject', $default_subject);

        // Message field.
        $mform->addElement('textarea', 'message', get_string('message', 'enrol_invitation'),
                array('class' => 'form-invite-message'));
        // Put help text to show what default message invitee gets.
        $mform->addHelpButton('message', 'message', 'enrol_invitation',
                get_string('message_help_link', 'enrol_invitation'));

        // Email options.
        // Prepare string variables.
        $temp = new stdClass();
        $temp->email = $USER->email;
        $temp->supportemail = $CFG->supportemail;
        $mform->addElement('checkbox', 'show_from_email', '',
                get_string('show_from_email', 'enrol_invitation', $temp));
        $mform->addElement('checkbox', 'notify_inviter', '',
                get_string('notify_inviter', 'enrol_invitation', $temp));
        $mform->setDefault('show_from_email', 1);
        $mform->setDefault('notify_inviter', 0);

        // Set defaults if the user is resending an invite that expired.
        if ( !empty($prefilled) ) {
            $mform->setDefault('role_group[roleid]', $prefilled['roleid']);
            $mform->setDefault('email', $prefilled['email']);
            $mform->setDefault('subject', $prefilled['subject']);
            $mform->setDefault('message', $prefilled['message']);
            $mform->setDefault('show_from_email', $prefilled['show_from_email']);
            $mform->setDefault('notify_inviter', $prefilled['notify_inviter']);
        }

        $this->add_action_buttons(false, get_string('inviteusers', 'enrol_invitation'));
    }

    /**
     * Overriding get_data, because we need to be able to handle daysexpire,
     * which is not defined as a regular form element.
     *
     * @return object
     */
    public function get_data() {
        $retval = parent::get_data();

        // Check if form validated, and if user submitted daysexpire from POST.
        if (!empty($retval) && isset($_POST['daysexpire'])) {
            if (in_array($_POST['daysexpire'], self::$daysexpire_options)) {
                // Cannot indicate to user a real error message, so just slightly
                // ignore user setting.
                $retval->daysexpire = $_POST['daysexpire'];
            }
        }

        return $retval;
    }

    /**
     * Given a role record, format string to be displayable to user. Filter out
     * role notes and other information.
     *
     * @param object $role  Record from role table.
     * @return string
     */
    private function format_role_string($role) {
        $role_string = html_writer::tag('span', $role->name . ':',
                array('class' => 'role-name'));

        // Role description has a <hr> tag to separate out info for users
        // and admins.
        $role_description = explode('<hr />', $role->description);

        // Need to clean html, because tinymce adds a lot of extra tags that mess up formatting.
        $role_description = $role_description[0];
        // Whitelist some formatting tags.
        $role_description = strip_tags($role_description, '<b><i><strong><ul><li><ol>');

        $role_string .= ' ' . $role_description;

        return $role_string;
    }

    /**
     * Private class method to return a list of appropiate roles for given
     * course and user.
     *
     * @param object $course    Course record.
     *
     * @return array            Returns array of roles indexed by role archetype.
     */
    private function get_appropiate_roles($course) {
        global $DB;
        $retval = array();
        $context = context_course::instance($course->id);
        $roles = get_assignable_roles($context);

        if (empty($roles)) {
            return $retval;
        }

        // Get full role records for archetype and description.
        foreach ($roles as $roleid => $rolename) {
            $record = $DB->get_record('role', array('id' => $roleid));
            $record->name = $rolename;  // User might have customised name.
            $retval[$record->archetype][] = $record;
        }

        return $retval;
    }

    /**
     * Provides custom validation rules.
     *  - Validating the email field here, rather than in definition, to allow
     *    multiple email addresses to be specified.
     *  - Validating that access end date is in the future.
     *
     * @param array $data
     * @param array $files
     *
     * @return array
     */
    public function validation($data, $files) {
        $errors = array();
        $delimiters = "/[;, \r\n]/";
        $email_list = self::parse_dsv_emails($data['email'], $delimiters);

        if (empty($email_list)) {
            $errors['email'] = get_string('err_email', 'form');
        }

        return $errors;
    }

    /**
     * Parses a string containing delimiter seperated values for email addresses.
     * Returns an empty array if an invalid email is found.
     *
     * @param string $emails           string of emails to be parsed
     * @param string $delimiters       list of delimiters as regex
     * @return array $parsed_emails    array of emails
     */
    public static function parse_dsv_emails($emails, $delimiters) {
        $parsed_emails = array();
        $emails = trim($emails);
        if (preg_match($delimiters, $emails)) {
            // Multiple email addresses specified.
            $dsv_emails = preg_split($delimiters, $emails, null, PREG_SPLIT_NO_EMPTY);
            foreach ($dsv_emails as $email_value) {
                $email_value = trim($email_value);
                if (!clean_param($email_value, PARAM_EMAIL)) {
                    return array();
                }
                $parsed_emails[] = $email_value;
            }
        } else if (clean_param($emails, PARAM_EMAIL)) {
            // Single email.
            return (array)$emails;
        } else {
            return array();
        }

        return $parsed_emails;
    }
}