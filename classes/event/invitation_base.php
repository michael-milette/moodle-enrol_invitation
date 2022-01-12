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
 * Base class for invitation events.
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2021 Lukas Celinak <lukascelinak@gmail.com> (see README.txt)
 * @author     Lukas Celinak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_invitation\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The mod_invitation abstract base event class.
 *
 * @package    enrol
 * @subpackage invitation
 * @copyright  2021 Lukas Celinak <lukascelinak@gmail.com> (see README.txt)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class invitation_base extends \core\event\base {

    protected $invitation;

    /**
     * Legacy log data.
     *
     * @var array
     */
    protected $legacylogdata;

    protected function init() {
        $this->data['crud'] = 'c'; // Valid options include: c)reate, r)ead, u)pdate and d)elete.
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'enrol_invitation_invitation_manager';
    }

    protected static function base_data($invitation) {
        $data = array(
            'context' => \context_course::instance($invitation->courseid),
            'objectid' => $invitation->courseid,
            'other' => (array) $invitation
        );

        (!isloggedin() or isguestuser()) && $invitation->userid ? $data['userid'] = $invitation->userid : null;
        return $data;
    }

    protected function set_invitation($invitation) {
        $this->add_record_snapshot('enrol_invitation', $invitation);
        $this->invitation = (array) $invitation;
        $this->data['objecttable'] = 'enrol_invitation';
    }

    /**
     * Get invitation instance.
     *
     * NOTE: to be used from observers only.
     *
     * @throws \coding_exception
     * @return \invitation_instance
     */
    public function get_invitation() {
        if ($this->is_restored()) {
            throw new \coding_exception('get_invitation() is intended for event observers only');
        }
        if (!isset($this->invitation)) {
            debugging('invitation property should be initialised in each event', DEBUG_DEVELOPER);
            global $CFG;
            require_once($CFG->dirroot . '/mod/invitation/locallib.php');
            $this->invitation = array();
        }
        return $this->invitation;
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/enrol/invitation/invitation.php', array('courseid' => $this->other['courseid']));
    }

}
