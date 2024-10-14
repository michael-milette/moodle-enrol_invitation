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
 * Form to display invitation.
 *
 * @package    enrol_invitation
 * @copyright  2021-2024 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @author     Michael Milette
 * @copyright  2013 UC Regents
 * @author     Rex Lorenzo
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('locallib.php');
require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/lib/enrollib.php');

/**
 * Class for sending invitation to enrol users in a course when the "Use invitation with default values" field is set to "Yes".
 *
 * @copyright  2021-2024 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class invitation_form extends moodleform {
    /**
     * The form definition if "Use invitation with default values" is set to "No".
     */
    public function definition() {
        global $CFG, $USER, $COURSE;
        $mform = & $this->_form;

        // Get rid of "Collapse all" in Moodle 2.5+.
        if (method_exists($mform, 'setDisableShortforms')) {
            $mform->setDisableShortforms(true);
        }

        // Add some hidden fields.
        $course = $this->_customdata['course'];
        $instance = $this->_customdata['instance'];
        $context = $this->_customdata['context'];
        $prefilled = $this->_customdata['prefilled'];
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $course->id);

        // Set roles.
        $mform->addElement('header', 'header_role', get_string('header_role', 'enrol_invitation'));

        $siteroles = $this->getappropiateroles($course);
        $label = get_string('assignrole', 'enrol_invitation');
        $rolegroup = [];
        foreach ($siteroles as $roletype => $roles) {
            $roletypestring = html_writer::tag('div', get_string('archetype' . $roletype, 'role'), ['class' => 'label badge-info']);
            $rolegroup[] = &$mform->createElement('static', 'role_type_header', '', $roletypestring);

            foreach ($roles as $role) {
                $rolestring = $this->formatrolestring($role);
                $rolegroup[] = &$mform->createElement('radio', 'roleid', '', $rolestring, $role->id);
            }
        }

        $mform->setDefault('roleid', 3);
        $mform->addGroup($rolegroup, 'role_group', $label, '<br>');
        $mform->addRule('role_group', get_string('norole', 'enrol_invitation'), 'required');

        // Email address field.
        $mform->addElement('header', 'header_email', get_string('header_email', 'enrol_invitation'));
        $mform->addElement(
            'textarea',
            'email',
            get_string('emailaddressnumber', 'enrol_invitation'),
            ['maxlength' => 1000, 'class' => 'form-invite-email', 'style' => 'resize: both;', 'cols' => 65, 'rows' => 5]
        );
        $mform->setType('email', PARAM_TEXT);
        // Check for correct email formatting later in validation() function.
        $mform->addElement('static', 'email_clarification', '', get_string('email_clarification', 'enrol_invitation'));

        $mform->setType('email', PARAM_TEXT);
        if ($CFG->branch >= 311) {
            $userfields = \core_user\fields::for_identity($context)->get_required_fields();
        } else {
            $userfields = get_extra_user_fields($context);
        }
        $options = [
            'ajax' => 'enrol_manual/form-potential-user-selector',
            'multiple' => true,
            'courseid' => $course->id,
            'enrolid' => $instance->id,
            'perpage' => $CFG->maxusersperpage,
            'userfields' => implode(',', $userfields),
            'valuehtmlcallback' => function ($value) {
                global $OUTPUT;
                if ($user = \core_user::get_user($value)) {
                    $useroptiondata = [
                        'fullname' => fullname($user),
                        'idnumber' => $user->idnumber,
                        'email' => $user->email,
                        'suspended' => 0,
                    ];
                    return $OUTPUT->render_from_template('enrol_manual/form-user-selector-suggestion', $useroptiondata);
                }
            },
        ];
        $mform->addElement('autocomplete', 'userlist', get_string('selectusers', 'enrol_manual'), [], $options);

        if (has_capability('moodle/cohort:manage', $context) || has_capability('moodle/cohort:view', $context)) {
            // Check to ensure there is at least one visible cohort before displaying the select box.
            // Ideally it would be better to call external_api::call_external_function('core_cohort_search_cohorts')
            // (which is used to populate the select box) instead of duplicating logic but there is an issue with globals
            // being borked (in this case $PAGE) when combining the usage of fragments and call_external_function().
            require_once($CFG->dirroot . '/cohort/lib.php');
            $availablecohorts = cohort_get_cohorts($context->id, 0, 1, '');
            $availablecohorts = $availablecohorts['cohorts'];
            if (!($context instanceof context_system)) {
                $availablecohorts = array_merge($availablecohorts, cohort_get_available_cohorts($context, COHORT_ALL, 0, 1, ''));
            }
            if (!empty($availablecohorts)) {
                $options = ['contextid' => $context->id, 'multiple' => true];
                $mform->addElement('cohort', 'cohortlist', get_string('selectcohorts', 'enrol_manual'), $options);
            }
        }
        $this->_customdata['registeredonly'] ? $mform->addElement(
            'static',
            'email_registered',
            '',
            get_string('registeredonly_help', 'enrol_invitation')
        ) : null;

        // Subject field.
        $mform->addElement('text', 'subject', get_string('subject', 'enrol_invitation'), ['class' => 'form-invite-subject']);
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', get_string('required'), 'required');
        $defaultsubject = get_string('default_subject', 'enrol_invitation', getcoursesubject($COURSE));
        $mform->setDefault('subject', $defaultsubject);

        // Message field.
        $mform->addElement('editor', 'message', get_string('message', 'enrol_invitation'), ['class' => 'form-invite-message']);
        $mform->setType('message', PARAM_RAW);

        // Put help text to show what default message invitee gets.
        $mform->addHelpButton('message', 'emailmsghtml', 'enrol_invitation', get_string('message_help_link', 'enrol_invitation'));

        // Email options.
        // Prepare string variables.
        $temp = new stdClass();
        $temp->email = $USER->email;
        $temp->supportemail = !empty($CFG->supportemail) ? $CFG->supportemail : $CFG->noreplyaddress;
        $mform->addElement('checkbox', 'show_from_email', '', get_string('show_from_email', 'enrol_invitation', $temp));
        $mform->addElement('checkbox', 'notify_inviter', '', get_string('notify_inviter', 'enrol_invitation', $temp));
        $mform->setDefault('show_from_email', 1);
        $mform->setDefault('notify_inviter', 0);

        // Set defaults if the user is resending an invite that expired.
        if (!empty($prefilled)) {
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
     * Overriding get_data, because we need to be able to handle daysexpire, which is not defined as a regular form element.
     *
     * @return object
     */
    public function get_data() {
        $retval = parent::get_data();

        // Check if form validated, and if user submitted daysexpire from POST.
        if (false) { // Not implemented yet.
            if (!empty($retval) && isset($_POST['daysexpire'])) {
                if (in_array($_POST['daysexpire'], self::$daysexpireoptions)) {
                    // Cannot indicate to user a real error message, so just slightly ignore user setting.
                    $retval->daysexpire = $_POST['daysexpire'];
                }
            }
        }
        return $retval;
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
     * Provides custom validation rules.
     *  - Validating the email field here, rather than in definition, to allow multiple email addresses to be specified.
     *  - Validating that access end date is in the future.
     *
     * @param array $data
     * @param array $files
     *
     * @return array
     */
    public function validation($data, $files) {
        $errors = [];
        $delimiters = "/[;, \r\n]/";
        $emaillist = self::parsedsvemails($data['email'], $delimiters);

        if (!empty($data['email']) && empty($emaillist)) {
            $errors['email'] = get_string('err_email', 'form');
        }

        return $errors;
    }

    /**
     * Parses a string containing delimiter separated values for email addresses.
     * Returns an empty array if an invalid email is found.
     *
     * @param string $emails       string of emails to be parsed
     * @param string $delimiters   list of delimiters as regex
     * @return array $parsedemails array of emails
     */
    public static function parsedsvemails($emails, $delimiters) {
        $parsedemails = [];
        $emails = trim($emails);
        if (preg_match($delimiters, $emails)) {
            // Multiple email addresses specified.
            $dsvemails = preg_split($delimiters, $emails, null, PREG_SPLIT_NO_EMPTY);
            foreach ($dsvemails as $emailvalue) {
                $emailvalue = trim($emailvalue);
                if (!clean_param($emailvalue, PARAM_EMAIL)) {
                    return [];
                }
                $parsedemails[] = $emailvalue;
            }
        } else if (clean_param($emails, PARAM_EMAIL)) {
            // Single email.
            return (array) $emails;
        } else {
            return [];
        }

        return $parsedemails;
    }

    /**
     * Get list of email addresses for users belonging to registered user accounts.
     *
     * @param array  $userlist List of user ids.
     * @return array Email addresses.
     */
    public static function parse_userlist_emails($userlist) {
        global $DB;
        $parsedemails = [];
        if ($userlist) {
            foreach ($userlist as $userid) {
                $parsedemails[] = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST)->email;
            }
        }
        return $parsedemails;
    }

    /**
     * Get list of email addresses belonging to users specified cohorts of a given course.
     *
     * @param array  $cohortlist List of cohort ids.
     * @param object $course Course object.
     * @return array Email addresses.
     */
    public static function parse_cohortlist_emails($cohortlist, $course) {
        global $DB;
        $parsedemails = [];
        if ($cohortlist) {
            foreach ($cohortlist as $cohortid) {
                $context = context_course::instance($course->id);
                [$esql, $params] = get_enrolled_sql($context);
                $sql = "SELECT cm.userid FROM {cohort_members} cm LEFT JOIN ($esql) u ON u.id = cm.userid " .
                        "WHERE cm.cohortid = :cohortid AND u.id IS NULL";
                $params['cohortid'] = $cohortid;
                $members = $DB->get_fieldset_sql($sql, $params);
                foreach ($members as $user) {
                    $parsedemails[] = $DB->get_record('user', ['id' => $user], '*', MUST_EXIST)->email;
                }
            }
        }
        return $parsedemails;
    }
}

/**
 * Class for sending invitation to enrol users in a course when the "Use invitation with default values" field is set to "No".
 */
class invitation_email_form extends moodleform {
    /**
     * The form definition if "Use invitation with default values" is set to "Yes".
     */
    public function definition() {
        global $CFG, $USER;
        $mform = & $this->_form;
        // Get rid of "Collapse all" in Moodle 2.5+.
        if (method_exists($mform, 'setDisableShortforms')) {
            $mform->setDisableShortforms(true);
        }
        // Add some hidden fields.
        $course = $this->_customdata['course'];
        $instance = $this->_customdata['instance'];
        $context = $this->_customdata['context'];
        $prefilled = $this->_customdata['prefilled'];
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $course->id);

        // Email address field.
        $mform->addElement('header', 'header_email', get_string('header_email', 'enrol_invitation'));
        $mform->addElement(
            'textarea',
            'email',
            get_string('emailaddressnumber', 'enrol_invitation'),
            ['maxlength' => 1000, 'class' => 'form-invite-email', 'style' => 'resize: both;', 'cols' => 65, 'rows' => 5]
        );
        $registeredonly = $this->_customdata['registeredonly'] ? '<br>'
            . get_string('registeredonly_help', 'enrol_invitation') : '';
        $mform->addElement('static', 'email_clarification', '', get_string(
            'email_clarification',
            'enrol_invitation'
        ) . $registeredonly);

        $mform->setType('email', PARAM_TEXT);
        if ($CFG->branch >= 311) {
            $userfields = \core_user\fields::for_identity($context)->get_required_fields();
        } else {
            $userfields = get_extra_user_fields($context);
        }

        if ($CFG->branch >= 311) {
            $userfields = \core_user\fields::get_identity_fields($context, false);
        }

        $options = [
            'ajax' => 'enrol_manual/form-potential-user-selector',
            'multiple' => true,
            'courseid' => $course->id,
            'enrolid' => $instance->id,
            'perpage' => $CFG->maxusersperpage,
            'userfields' => implode(',', $userfields),
            'valuehtmlcallback' => function ($value) {
                global $OUTPUT;
                if ($user = \core_user::get_user($value)) {
                    $useroptiondata = [
                        'fullname' => fullname($user),
                        'idnumber' => $user->idnumber,
                        'email' => $user->email,
                        'suspended' => 0,
                    ];
                    return $OUTPUT->render_from_template('enrol_manual/form-potential-user-selector', $useroptiondata);
                }
            },
        ];
        $mform->addElement('autocomplete', 'userlist', get_string('selectusers', 'enrol_manual'), [], $options);

        if (has_capability('moodle/cohort:manage', $context) || has_capability('moodle/cohort:view', $context)) {
            // Check to ensure there is at least one visible cohort before displaying the select box.
            // Ideally it would be better to call external_api::call_external_function('core_cohort_search_cohorts')
            // (which is used to populate the select box) instead of duplicating logic but there is an issue with globals
            // being borked (in this case $PAGE) when combining the usage of fragments and call_external_function().
            require_once($CFG->dirroot . '/cohort/lib.php');
            $availablecohorts = cohort_get_cohorts($context->id, 0, 1, '');
            $availablecohorts = $availablecohorts['cohorts'];
            if (!($context instanceof context_system)) {
                $availablecohorts = array_merge($availablecohorts, cohort_get_available_cohorts($context, COHORT_ALL, 0, 1, ''));
            }
            if (!empty($availablecohorts)) {
                $options = ['contextid' => $context->id, 'multiple' => true];
                $mform->addElement('cohort', 'cohortlist', get_string('selectcohorts', 'enrol_manual'), $options);
            }
        }
        // Check for correct email formating later in validation() function.

        // Set defaults if the user is resending an invite that expired.
        if (!empty($prefilled)) {
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
        if (false) { // Not implemented yet.
            if (!empty($retval) && isset($_POST['daysexpire'])) {
                if (in_array($_POST['daysexpire'], self::$daysexpireoptions)) {
                    // Cannot indicate to user a real error message, so just slightly ignore user setting.
                    $retval->daysexpire = $_POST['daysexpire'];
                }
            }
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
        $errors = [];
        $delimiters = "/[;, \r\n]/";
        $emaillist = self::parsedsvemails($data['email'], $delimiters);

        if (empty($emaillist) && empty($data['userlist']) && empty($data['cohortlist'])) {
            $errors['email'] = get_string('err_email', 'form');
            $errors['userlist'] = get_string('err_userlist', 'enrol_invitation');
            $errors['cohortlist'] = get_string('err_cohortlist', 'enrol_invitation');
        }

        return $errors;
    }

    /**
     * Parses a string containing delimiter seperated values for email addresses.
     * Returns an empty array if an invalid email is found.
     *
     * @param string $emails        string of emails to be parsed
     * @param string $delimiters    list of delimiters as regex
     * @return array $parsedemails array of emails
     */
    public static function parsedsvemails($emails, $delimiters) {
        $parsedemails = [];
        $emails = trim($emails);
        if (preg_match($delimiters, $emails)) {
            // Multiple email addresses specified.
            $dsvemails = preg_split($delimiters, $emails, null, PREG_SPLIT_NO_EMPTY);
            foreach ($dsvemails as $emailvalue) {
                $emailvalue = trim($emailvalue);
                if (!clean_param($emailvalue, PARAM_EMAIL)) {
                    return [];
                }
                $parsedemails[] = $emailvalue;
            }
        } else if (clean_param($emails, PARAM_EMAIL)) {
            // Single email.
            return (array) $emails;
        } else {
            return [];
        }

        return $parsedemails;
    }
}
