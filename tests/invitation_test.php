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
 * PHPUnit site invitation tests.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/enrol/invitation/invitation_form.php');
require_once($CFG->dirroot . '/enrol/invitation/lib.php');
require_once($CFG->dirroot . '/enrol/invitation/locallib.php');

/**
 * PHPunit tests for the invitation manager.
 *
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class invitation_manager_testcase extends advanced_testcase {
    /**
     * Invitation manager instance.
     * 
     * @var invitation_manager
     */
    private $invitationmanager = null;

    /**
     * Course object.
     *
     * @var object
     */
    private $testcourse = null;

    /**
     * Invitee user object.
     *
     * @var object
     */
    private $testinvitee = null;

    /**
     * Inviter user object.
     *
     * @var object
     */
    private $testinviter = null;

    /**
     * Try to enroll a user with an invitation that has daysexpire set. Make
     * sure that the proper timeend is set.
     *
     * @dataProvider daystoexpire_provider
     */
    public function test_enroluser_withdaysexpire($daystoexpire) {
        global $DB;

        // When enrolling a user, the invitation user uses the currently logged
        // in user's id, so we need to set that to the invitee.
        $this->setUser($this->testinvitee);

        $invite = $this->create_invite();
        $invite->daysexpire = $daystoexpire;
        $this->invitationmanager->enroluser($invite);

        // Check user_enrolments table and make sure endtime is $daystoexpire
        // days ahead.
        $timeend = $DB->get_field('user_enrolments', 'timeend',
                array('userid' => $this->testinvitee->id,
                      'enrolid' => $this->invitationmanager->enrol_instance->id));
        // Do not count today as one of the days.
        $expectedexpiration = strtotime(date('Y-m-d'))+86400*($daystoexpire+1)-1;
        $this->assertEquals($expectedexpiration, intval($timeend));
    }

    /**
     * Makes sure that someone who was granted the role of Temorary Participant
     * and has their site invitation user enrollment expired, that they are
     * unenrolled from the course.
     */
    public function test_unenrolexpiredtempparticipant() {
        global $DB;

        // Create Temporary Participant role.
        $roleid = create_role('Temporary Participant', 'tempparticipant', '', 'student');
        $this->assertGreaterThan(0, $roleid);

        // Test setup.
        $invitation = enrol_get_plugin('invitation');
        $this->setUser($this->testinvitee);
        $context = context_course::instance($this->testcourse->id);
        set_config('enabletempparticipant', 1, 'enrol_invitation');

        // Enrol user with an timeend in the past.
        $invitation->enrol_user($this->invitationmanager->enrol_instance,
                $this->testinvitee->id, $roleid, 0, strtotime('yesterday'));
        $hasrole = has_role_in_context('tempparticipant', $context);
        $this->assertTrue($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertTrue($isenrolled);

        // Run the enrollment plugin cron and make sure user is unenrolled.
        $invitation->cron();
        $hasrole = has_role_in_context('tempparticipant', $context);
        $this->assertFalse($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertFalse($isenrolled);

        // Now do the opposite, enroll a user with a timeend in the future.
        $invitation->enrol_user($this->invitationmanager->enrol_instance,
                $this->testinvitee->id, $roleid, 0, strtotime('tomorrow'));
        $hasrole = has_role_in_context('tempparticipant', $context);
        $this->assertTrue($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertTrue($isenrolled);

        // Run the enrollment plugin cron and make sure user is not unenrolled.
        $invitation->cron();
        $hasrole = has_role_in_context('tempparticipant', $context);
        $this->assertTrue($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertTrue($isenrolled);

        // Enroll someone with a role other than Temporary Participant and
        // make sure they are not unenrolled.
        $studentroleid = $DB->get_field('role', 'id', array('shortname' => 'student'));
        $invitation->enrol_user($this->invitationmanager->enrol_instance,
                $this->testinvitee->id, $studentroleid);
        $hasrole = has_role_in_context('student', $context);
        $this->assertTrue($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertTrue($isenrolled);
        $invitation->cron();
        $hasrole = has_role_in_context('student', $context);
        $this->assertTrue($hasrole);
        $isenrolled = is_enrolled($context, $this->testinvitee->id);
        $this->assertTrue($isenrolled);
    }

    public function daystoexpire_provider() {
        $ret_val = array();
        foreach (invitation_form::$daysexpire_options as $daysexpire) {
            $ret_val[] = array($daysexpire);
        }
        return $ret_val;
    }

    /**
     * Helper method to create standard invite object. Can be customized later.
     */
    private function create_invite() {
        global $DB;

        $invitation = new stdClass();
        $invitation->token = '517b12e81e212';
        $invitation->email = $this->testinvitee->email;
        $invitation->userid = 0;    // Do not have the invitee's id is yet.
        $invitation->roleid = $DB->get_field('role', 'id', array('shortname' => 'student'));
        $invitation->courseid = $this->testcourse->id;
        $invitation->tokenused = 0;
        $invitation->timesent = time();
        $invitation->timesent = strtotime('+2 weeks');
        $invitation->inviterid = $this->testinviter->id;
        $invitation->subject = 'Test';
        $invitation->notify_inviter = 0;
        $invitation->show_from_email = 1;
        $invitation->daysexpire = 0;

        return $invitation;
    }

    /**
     * Setup method.
     *
     * Create course, inviter, invitee, and invitation manager instances.
     */
    protected function setUp() {
        $this->resetAfterTest(true);
        // Create new course/users.
        $this->testcourse = $this->getDataGenerator()->create_course();
        $this->testinvitee = $this->getDataGenerator()->create_user();
        $this->testinviter = $this->getDataGenerator()->create_user();
        // Make sure that created course has the invitation enrollment plugin.
        $invitation = enrol_get_plugin('invitation');
        $invitation->add_instance($this->testcourse);
        // Create manager that we want to test.
        $this->invitationmanager = new invitation_manager($this->testcourse->id);
    }
}