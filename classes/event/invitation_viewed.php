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
 * The invitation_viewed event.
 *
 * @package    enrol_invitation
 * @copyright  2021-2023 TNG Consulting Inc. {@link https://www.tngconsulting.ca}
 * @copyright  2021 Christian Brugger (brugger.chr@gmail.com)
 * @author     Christian Brugger
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_invitation\event;

class invitation_viewed extends invitation_base {
    protected function init() {
        $this->data['crud'] = 'r';  // Valid options include: c)reate, r)ead, u)pdate and d)elete.
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'enrol_invitation_invitation_manager';
    }

    /**
     * Create this event on a given invitation.
     *
     * @param object $invitation
     * @return \core\event\base
     */
    public static function create_from_invitation($invitation) {
        $event = self::create(self::base_data($invitation));
        $event->set_invitation($invitation);
        return $event;
    }

    public static function get_name() {
        return get_string('event_invitation_viewed', 'enrol_invitation');
    }

    public function get_description() {
        $userid = empty($this->userid) ? get_string('anonymoususer', 'enrol_invitation') : $this->userid;
        $description = get_string('vieweddescription', 'enrol_invitation',
                ['userid' => $userid, 'courseid' => $this->other['courseid'], 'email' => $this->other['email']]);
        return $description;
    }

    public function get_url() {
        return new \moodle_url('/enrol/invitation/history.php', array('courseid' => $this->other['courseid']));
    }

}
