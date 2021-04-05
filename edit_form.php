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
 * Form to add new instance of enrol_invitation or edit current instance.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once('locallib.php');

/**
 * Form page for enrol settings.
 *
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */
class enrol_invitation_edit_form extends moodleform {

    /**
     * Defines what settings a user can modify.
     */
    public function definition() {
        global $USER, $CFG, $COURSE;
        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_invitation'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);

        $options = array(ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no'));
        $mform->addElement('select', 'status', get_string('status', 'enrol_invitation'), $options);
        $mform->setDefault('status', $plugin->get_config('status'));
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

                $optionsd = array(0 => get_string('no'),
            1 => get_string('yes'));
        $mform->addElement('select', 'customint5', get_string('registeredonly', 'enrol_invitation'), $optionsd);
        $mform->setDefault('customint5', 0);
        // Set roles.
        $mform->addElement('header', 'header_default', get_string('defaultinvitevalues', 'enrol_invitation'));
        $optionsd = array(0 => get_string('no'),
            1 => get_string('yes'));
        $mform->addElement('select', 'customint1', get_string('usedefaultvalues', 'enrol_invitation'), $optionsd);
        $mform->setDefault('customint1', 0);

        $site_roles = $this->get_appropiate_roles($COURSE);
        $label = get_string('assignrole', 'enrol_invitation');
        $role_group = array();
        foreach ($site_roles as $role_type => $roles) {
            $role_type_string = html_writer::tag('div',
                            get_string('archetype' . $role_type, 'role'),
                            array('class' => 'label badge-info'));
            $role_group[] = &$mform->createElement('static', 'role_type_header',
                            '', $role_type_string);

            foreach ($roles as $role) {
                $role_string = $this->format_role_string($role);
                $role_group[] = &$mform->createElement('radio', 'customint2', '',
                                $role_string, $role->id);
            }
        }
        
        $mform->setDefault('customint2', 3);
        $mform->addGroup($role_group, 'role_group', $label);

        // Ssubject field.
        $mform->addElement('text', 'customchar1', get_string('subject', 'enrol_invitation'),
                array('class' => 'form-invite-subject'));
        $mform->setType('customchar1', PARAM_TEXT);
        // Default subject is "Site invitation for <course title>".
        $default_subject = get_string('default_subject', 'enrol_invitation',
                sprintf('%s: %s', $COURSE->shortname, $COURSE->fullname));
        $mform->setDefault('customchar1', $default_subject);

        // Message field.
        //
        // $mform->addElement('textarea', 'message', get_string('message', 'enrol_invitation'),
        //         array('class' => 'form-invite-message'));

        $mform->addElement('editor', 'customtext1', get_string('message', 'enrol_invitation'),
                array('class' => 'form-invite-message'));
        $mform->setType('message', PARAM_RAW);


        // Put help text to show what default message invitee gets.
        $mform->addHelpButton('customtext1', 'message', 'enrol_invitation',
                get_string('message_help_link', 'enrol_invitation'));

        // Email options.
        // Prepare string variables.
        $temp = new stdClass();
        $temp->email = $USER->email;
        $temp->supportemail = $CFG->supportemail;
        $mform->addElement('checkbox', 'customint3', '',
                get_string('show_from_email', 'enrol_invitation', $temp));
        $mform->addElement('checkbox', 'customint4', '',
                get_string('notify_inviter', 'enrol_invitation', $temp));
        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $mform->disabledIf('role_group', 'customint1', 'eq', 0);
        $mform->disabledIf('customchar1', 'customint1', 'eq', 0);
        $mform->disabledIf('customtext1', 'customint1', 'eq', 0);
        $mform->disabledIf('customint3', 'customint1', 'eq', 0);
        $mform->disabledIf('customint4', 'customint1', 'eq', 0);
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
    public function get_appropiate_roles($course) {
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

}
