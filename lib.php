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
 * Invitation enrolment plugin.
 *
 * This plugin allows you to send invitation by email. These invitations can be used only once. Users
 * clicking on the email link are automatically enrolled.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Invitation enrolment plugin implementation.
 *
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
        return array(new pix_icon('invite', get_string('pluginname',
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
                or !has_capability('enrol/invitation:config', $context)) {
            return null;
        }

        // We don't want more than one instance per course.
        if ($DB->record_exists('enrol', array('courseid'=>$courseid, 'enrol'=>'invitation'))) {
            return null;
        }

        return new moodle_url('/enrol/invitation/edit.php', array('courseid'=>$courseid));
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

        if ($result = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>'invitation'))) {
            // Instance already exists, so just give id.
            return $result->id;
        }

        return parent::add_instance($course, $fields);
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
            $managelink = new moodle_url('/enrol/invitation/edit.php', array('courseid'=>$instance->courseid, 'id'=>$instance->id));
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
                array('courseid'=>$instance->courseid, 'id'=>$instance->id));
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
        if ($this->allow_unenrol($instance) && has_capability("enrol/invitation:unenrol", $context)) {
            $url = new moodle_url('/enrol/invitation/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/delete', ''), get_string('unenrol', 'enrol'),
                $url, array('class'=>'unenrollink', 'rel'=>$ue->id));
        }
        if ($this->allow_manage($instance) && has_capability("enrol/invitation:manage", $context)) {
            $url = new moodle_url('/enrol/invitation/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url,
                array('class'=>'editenrollink', 'rel'=>$ue->id));
        }
        return $actions;
    }

    /**
     * If site invite is using the Temporary Participant role, then need to
     * periodically check and remove the role if it is expired.
     *
     * @return boolean
     */
    public function cron() {
        global $DB;

        if (!enrol_is_enabled('self') ||
                !get_config('enrol_invitation', 'enabletempparticipant')) {
            return true;
        }

        $plugin = enrol_get_plugin('invitation');

        // Find all enrollment records in which a person was enrolled in a
        // course via Site invitation with the role of Temporary Participant
        // that have expired.
        $sql = "SELECT  e.*,
                        ra.roleid AS raroleid,
                        ra.userid AS rauserid,
                        ra.contextid AS racontextid,
                        ra.component AS racomponent,
                        ra.itemid AS raitemid
                FROM    {course} c
                JOIN    {enrol} e ON (
                            e.enrol='invitation' AND
                            e.courseid=c.id
                        )
                JOIN    {user_enrolments} ue ON (
                            ue.enrolid=e.id
                        )
                JOIN    {role_assignments} ra ON (
                            ra.component='enrol_invitation' AND
                            ra.itemid=e.id AND
                            ra.userid=ue.userid
                        )
                JOIN    {role} r ON (
                            r.id=ra.roleid
                        )
                WHERE   ue.timeend!=0 AND
                        :now > ue.timeend AND
                        r.shortname='tempparticipant'";
        $rs = $DB->get_recordset_sql($sql, array('now' => time()));

        if ($rs->valid()) {
            $rafields = array('roleid', 'userid', 'contextid', 'component', 'itemid');
            foreach ($rs as $instance) {
                // First remove expired role from user.

                // Rather than repeating the getting and resetting of variables
                // just do it in a loop.
                foreach ($rafields as $varname) {
                    $$varname = $instance->{'ra'.$varname};
                    unset($instance->{'ra'.$varname});
                }

                // Variables for this function are autogenerated above.
                role_unassign($roleid, $userid, $contextid, $component, $itemid);

                // Now $expiredenrollment should only be the enrol instance.
                $plugin->unenrol_user($instance, $userid);

                mtrace("unenrolling user $userid from course $instance->courseid because of expired Temporary Participant
                    invitation");
            }
        }
        $rs->close();

        return true;
    }
}