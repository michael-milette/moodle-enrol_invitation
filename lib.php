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
 * Library file to include classes and functions used.
 *
 * @package    enrol_invitation
 * @copyright  2021-2023 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Invitation enrolment plugin implementation.
 *
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_invitation_plugin extends enrol_plugin {

    /**
     * Returns optional enrolment information icons.
     *
     * This is used in course list for quick overview of enrolment options.
     *
     * We are not using single instance parameter because sometimes
     * we might want to prevent icon repetition when multiple instances
     * of one type exist. One instance may also produce several icons.
     *
     * @param array $instances all enrol instances of this type in one course.
     * @return array of pix_icon.
     */
    public function get_info_icons(array $instances) {
        return array(new pix_icon('icon', get_string('pluginname',
                'enrol_invitation'), 'enrol_invitation'));
    }

    /**
     * Users with unenrol cap may unenrol other users manually - requires
     * enrol/invitation:unenrol.
     *
     * @param stdClass $instance
     * @return boolean              Returns true.
     */
    public function allow_unenrol(stdClass $instance) {
        return true;
    }

    /**
     * Users with manage cap may tweak period and status - requires
     * enrol/invitation:manage.
     *
     * @param stdClass $instance
     * @return boolean              Returns true.
     */
    public function allow_manage(stdClass $instance) {
        return true;
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment
     * plugin in course.
     *
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        global $DB;

        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context)
                or!has_capability('enrol/invitation:config', $context)) {
            return null;
        }

        // We don't want more than one instance per course.
        if ($DB->record_exists('enrol', array('courseid' => $courseid, 'enrol' => 'invitation'))) {
            return null;
        }

        return new moodle_url('/enrol/invitation/edit.php', array('courseid' => $courseid));
    }

    /**
     * Ensures existence instance of enrol plugin.
     *
     * @param object $course
     * @param array $fields
     * @return int              Id of instance, null if can not be created.
     */
    public function add_instance($course, array $fields = null) {
        global $DB;

        if ($result = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => 'invitation'))) {
            // Instance already exists, so just give id.
            return $result->id;
        }

        return parent::add_instance($course, $fields);
    }

    /**
     * Restore instance and map settings.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $course
     * @param int $oldid
     */
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
        global $DB;

        if ($instance = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => $this->get_name()))) {
            $instanceid = $instance->id;
        } else {
            $instanceid = $this->add_instance($course, (array)$data);
        }
        $step->set_mapping('enrol', $oldid, $instanceid);
    }

    /**
     * Restore user enrolment.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $instance
     * @param int $userid
     * @param int $oldinstancestatus
     */
    public function restore_user_enrolment(restore_enrolments_structure_step $step, $data, $instance, $userid, $oldinstancestatus) {
        $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, $data->status);
    }

    /**
     * Sets up navigation entries.
     *
     * @param navigation_node $instancesnode
     * @param stdClass $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'invitation') {
            throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/invitation:config', $context)) {
            $managelink = new moodle_url('/enrol/invitation/edit.php', ['courseid' => $instance->courseid, 'id' => $instance->id]);
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Returns edit icons for the page with list of instances
     *
     * @param stdClass $instance
     * @return array
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'invitation') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/invitation:config', $context)) {
            $editlink = new moodle_url("/enrol/invitation/edit.php", ['courseid' => $instance->courseid, 'id' => $instance->id]);
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit'), 'core', ['class' => 'icon']));
        }

        return $icons;
    }

    /**
     * Creates course enrol form, checks if form submitted
     * and enrols user if necessary. It can also redirect.
     *
     * @param stdClass $instance
     * @return string html text, usually a form in a text box
     */
    public function enrol_page_hook(stdClass $instance) {

    }

    /**
     * Returns an enrol_user_button that takes the user to a page where they are able to
     * enrol users into the managers course through this plugin.
     *
     * Optional: If the plugin supports manual enrolments it can choose to override this
     * otherwise it shouldn't.
     *
     * @param course_enrolment_manager $manager
     * @return enrol_user_button|false
     */
    public function get_manual_enrol_button(course_enrolment_manager $manager) {
        global $CFG;

        $instance = null;
        $instances = array();
        foreach ($manager->get_enrolment_instances() as $tempinstance) {
            if ($tempinstance->enrol == 'invitation') {
                if ($instance === null) {
                    $instance = $tempinstance;
                }
                $instances[] = array('id' => $tempinstance->id, 'name' => $this->get_instance_name($tempinstance));
            }
        }
        if (empty($instance)) {
            return false;
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/invitation:enrol', $context)) {
            $invitelink = new moodle_url('/enrol/invitation/invitation.php',
                    array('courseid' => $instance->courseid, 'id' => $instance->id));
            $button = new enrol_user_button($invitelink,
                    get_string('inviteusers', 'enrol_invitation'), 'get');
            return $button;
        } else {
            return false;
        }
    }

    /**
     * Gets an array of the user enrolment actions.
     *
     * @param course_enrolment_manager $manager
     * @param stdClass $ue
     * @return array An array of user_enrolment_actions
     */
    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
        $actions = array();
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;
        if ($this->allow_manage($instance) && has_capability("enrol/invitation:manage", $context)) {
            $url = new moodle_url('/enrol/invitation/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url,
                    array('class' => 'editenrollink', 'rel' => $ue->id));
        }
        if ($this->allow_unenrol($instance) && has_capability("enrol/invitation:unenrol", $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/delete', ''),
                get_string('unenrol', 'enrol'),
                $url,
                ['class' => 'unenrollink', 'rel' => $ue->id]
            );
        }
        return $actions;
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/invitation:config', $context);
    }


    /**
     * Get icon mapping for font-awesome.
     */
    public function enrol_invitation_get_fontawesome_icon_map() {
        return ['enrol_invitation:invite' => 'fa-plane'];
    }


    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/invitation:config', $context);
    }

    /**
     * Return an array of valid options for the status.
     *
     * @return array
     */
    protected function get_status_options() {
        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        return $options;
    }

}

/**
 * Create course name for email subject line.
 *
 * @param object  $course Course objet.
 * @return string Formatted name of course subject.
 */
function getcoursesubject($course) {
    switch(get_config('enrol_invitation', 'defaultsubjectformat') ?? '') {
        case 'custom':
            $subject = get_string('customsubjectformat', 'enrol_invitation',
                    (object)['shortname' => $course->shortname, 'fullname' => $course->fullname]);
            break;
        case 'shortname':
            $subject = $course->shortname;
            break;
        default: // Fullname.
            $subject = $course->fullname;
    }
    return $subject;
}
