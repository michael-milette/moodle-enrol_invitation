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
 * Form to add new instance of enrol_invitation or edit current instance.
 *
 * @package    enrol_invitation
 * @copyright  2021-2024 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author     Michael Milette
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once('locallib.php');

/**
 * Form page for enrol settings.
 *
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */
class enrol_invitation_edit_form extends moodleform {
    /**
     * Defines what settings a user can modify.
     */
    public function definition() {
        global $USER, $CFG, $COURSE;
        $mform = $this->_form;

        [$instance, $plugin, $context] = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_invitation'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);

        $options = [ENROL_INSTANCE_ENABLED => get_string('yes'), ENROL_INSTANCE_DISABLED => get_string('no')];
        $mform->addElement('select', 'status', get_string('status', 'enrol_invitation'), $options);
        $mform->setDefault('status', $plugin->get_config('status'));
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $optionsd = [0 => get_string('no'), 1 => get_string('yes')];

        $mform->addElement('select', 'customint5', get_string('registeredonly', 'enrol_invitation'), $optionsd);
        $mform->setDefault('customint5', 0);

        $mform->addElement('select', 'customint6', get_string('enrolconfimation', 'enrol_invitation'), $optionsd);
        $mform->setDefault('customint6', 0);
        // Set roles.
        $mform->addElement('header', 'header_default', get_string('defaultinvitevalues', 'enrol_invitation'));
        $mform->addElement('select', 'customint1', get_string('usedefaultvalues', 'enrol_invitation'), $optionsd);
        $mform->setDefault('customint1', 0);

        $siteroles = $this->getappropiateroles($COURSE);
        $label = get_string('assignrole', 'enrol_invitation');
        $rolegroup = [];
        foreach ($siteroles as $roletype => $roles) {
            $roletypestring = html_writer::tag('div', get_string('archetype' . $roletype, 'role'), ['class' => 'label badge-info']);
            $rolegroup[] = &$mform->createElement('static', 'role_type_header', '', $roletypestring);

            foreach ($roles as $role) {
                $rolestring = $this->formatrolestring($role);
                $rolegroup[] = &$mform->createElement('radio', 'customint2', '', $rolestring, $role->id);
            }
        }
        $mform->setDefault('customint2', 3);
        $mform->addGroup($rolegroup, 'role_group', $label, '<br>');

        // Subject field.
        $mform->addElement('text', 'customchar1', get_string('subject', 'enrol_invitation'), ['class' => 'form-invite-subject']);
        $mform->setType('customchar1', PARAM_TEXT);
        $defaultsubject = get_string('default_subject', 'enrol_invitation', getcoursesubject($COURSE));
        $mform->setDefault('customchar1', $defaultsubject);

        // Message field.
        $mform->addElement('editor', 'customtext1', get_string('message', 'enrol_invitation'), ['class' => 'form-invite-message']);
        $mform->setType('message', PARAM_RAW);

        // Put help text to show what default message invitee gets.
        $mform->addHelpButton(
            'customtext1',
            'emailmsghtml',
            'enrol_invitation',
            get_string('message_help_link', 'enrol_invitation')
        );

        // Email options.
        // Prepare string variables.
        $temp = new stdClass();
        $temp->email = $USER->email;
        $temp->supportemail = !empty($CFG->supportemail) ? $CFG->supportemail : $CFG->noreplyaddress;
        $mform->addElement('checkbox', 'customint3', '', get_string('show_from_email', 'enrol_invitation', $temp));
        $mform->setDefault('customint3', 0);
        $mform->addElement('checkbox', 'customint4', '', get_string('notify_inviter', 'enrol_invitation', $temp));
        $mform->setDefault('customint4', 0);
        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $mform->disabledIf('role_group', 'customint1', 'eq', 0);
        $mform->disabledIf('customchar1', 'customint1', 'eq', 0);
        $mform->disabledIf('customtext1', 'customint1', 'eq', 0);
        $mform->disabledIf('customint3', 'customint1', 'eq', 0);
        $mform->disabledIf('customint4', 'customint1', 'eq', 0);
    }

    /**
     * Given a role record, format string to be displayable to user. Filter out role notes and other information.
     *
     * @param object $role  Record from role table.
     * @return string
     */
    private function formatrolestring($role) {
        $rolestring = html_writer::tag('span', $role->name, ['class' => 'role-name']);

        // Role description has a <hr> tag to separate out info for users and admins.
        if (strpos($role->description, '<hr />') !== false) {
            $roledescription = explode('<hr />', $role->description);
        } else if (strpos($role->description, '<hr>') !== false) {
            $roledescription = explode('<hr>', $role->description);
        } else {
            $roledescription[0] = $role->description;
        }

        // Need to clean html, because tinymce adds a lot of extra tags that mess up formatting.
        $roledescription = $roledescription[0];
        // Whitelist some formatting tags.
        $roledescription = strip_tags($roledescription, '<b><i><strong><ul><li><ol>');

        if (!empty($roledescription)) {
            $rolestring .= ': ' . $roledescription;
        }

        return $rolestring;
    }

    /**
     * Private class method to return a list of appropriate roles for given course and user.
     *
     * @param object $course Course record.
     * @return array         Returns array of roles indexed by role archetype.
     */
    private function getappropiateroles($course) {
        global $DB;
        $retval = [];
        $context = context_course::instance($course->id);
        $roles = get_assignable_roles($context);

        if (empty($roles)) {
            return $retval;
        }

        // Get full role records for archetype and description.
        foreach ($roles as $roleid => $rolename) {
            $record = $DB->get_record('role', ['id' => $roleid]);
            $record->name = $rolename;  // User might have customised name.
            $retval[$record->archetype][] = $record;
        }

        return $retval;
    }

    /**
     * Form validation.
     *
     * @param array $data
     * @param array $files
     *
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!empty($data['customint1'])) {
            if (empty($data['role_group'])) {
                $errors['role_group'] = get_string('err_required', 'form');
            }
            if (empty($data['customchar1'])) {
                $errors['customchar1'] = get_string('err_required', 'form');
            }
            if (empty($data['customtext1']['text'])) {
                $errors['customtext1'] = get_string('err_required', 'form');
            }
        }

        return $errors;
    }
}
