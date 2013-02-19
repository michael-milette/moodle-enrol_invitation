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
 * Invitation enrolment plugin.
 *
 * This plugin allows you to send invitation by email. These invitations can be used only once. Users
 * clicking on the email link are automatically enrolled.
 *
 * @package    enrol
 * @subpackage invitation
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Invitation enrolment plugin implementation.
 * @author  Jerome Mouneyrac
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances) {
        return array(new pix_icon('invite', get_string('pluginname', 'enrol_invitation'), 'enrol_invitation'));
    }

    public function roles_protected() {
        // users with role assign cap may tweak the roles later
        return false;
    }

    public function allow_unenrol(stdClass $instance) {
        // users with unenrol cap may unenrol other users manually - requires enrol/invitation:unenrol
        return true;
    }

    public function allow_manage(stdClass $instance) {
        // users with manage cap may tweak period and status - requires enrol/invitation:manage
        return true;
    }
    
     /**
     * Attempt to automatically enrol current user in course without any interaction,
     * calling code has to make sure the plugin and instance are active.
     *
     * This should return either a timestamp in the future or false.
     *
     * @param stdClass $instance course enrol instance
     * @param stdClass $user record
     * @return bool|int false means not enrolled, integer means timeend
     */
    public function try_autoenrol(stdClass $instance) {
        global $USER;

        return false;
    }
    
    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        global $DB;

        $context = context_course::instance($courseid);

        if (!has_capability('moodle/course:enrolconfig', $context) 
                or !has_capability('enrol/invitation:config', $context)) {
            return NULL;
        }

        //we don't want more than one instance per course
        if ($DB->record_exists('enrol', array('courseid'=>$courseid, 'enrol'=>'invitation'))) {
            return NULL;
        }

        return new moodle_url('/enrol/invitation/edit.php', array('courseid'=>$courseid));
    }
    
    /**
     * Add new instance of enrol plugin.
     * @param object $course
     * @param array instance fields
     * @return int id of new instance, null if can not be created
     */
    public function add_instance($course, array $fields = NULL) {
        global $DB;

        if ($DB->record_exists('enrol', array('courseid'=>$course->id, 'enrol'=>'invitation'))) {
            // only one instance allowed, sorry
            return NULL;
        }

        return parent::add_instance($course, $fields);
    }
    
     

    /**
     * Sets up navigation entries.
     *
     * @param object $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'invitation') {
             throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/invitation:config', $context)) {
            $managelink = new moodle_url('/enrol/invitation/edit.php', array('courseid'=>$instance->courseid, 'id'=>$instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Returns edit icons for the page with list of instances
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
            $editlink = new moodle_url("/enrol/invitation/edit.php", array('courseid'=>$instance->courseid, 'id'=>$instance->id));
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('i/edit', get_string('edit'), 'core', array('class'=>'icon')));
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
    function enrol_page_hook(stdClass $instance) {}
    
    /**
     * Returns an enrol_user_button that takes the user to a page where they are able to
     * enrol users into the managers course through this plugin.
     *
     * Optional: If the plugin supports manual enrolments it can choose to override this
     * otherwise it shouldn't
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
                array('courseid'=>$instance->courseid, 'id'=>$instance->id));
            $button = new enrol_user_button($invitelink, 
                    get_string('inviteusers', 'enrol_invitation'), 'post');
            return $button;
        } else {
            return false;
        }
    }
    
    

    /**
     * Gets an array of the user enrolment actions
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
        if ($this->allow_unenrol($instance) && has_capability("enrol/invitation:unenrol", $context)) {
            $url = new moodle_url('/enrol/invitation/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/delete', ''), get_string('unenrol', 'enrol'), $url, array('class'=>'unenrollink', 'rel'=>$ue->id));
        }
        if ($this->allow_manage($instance) && has_capability("enrol/invitation:manage", $context)) {
            $url = new moodle_url('/enrol/invitation/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url, array('class'=>'editenrollink', 'rel'=>$ue->id));
        }
        return $actions;
    }

    /**
     * Returns true if the plugin has one or more bulk operations that can be performed on
     * user enrolments.
     *
     * @return bool
     */
    public function has_bulk_operations() {
       return false;
    }

    /**
     * Return an array of enrol_bulk_enrolment_operation objects that define
     * the bulk actions that can be performed on user enrolments by the plugin.
     *
     * @return array
     */
    public function get_bulk_operations() {
        return array();
    }

}
