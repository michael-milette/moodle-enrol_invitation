<?php

/**
 * Base class for invitation events.
 *
 * @package    mod
 * @subpackage invitation
 * @copyright  2018 Lukas Celinak <lukascelinak@gmail.com> (see README.txt)
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
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'enrol_invitation_invitation_manager';
    }


    protected static function base_data($invitation) {
        $data= array(
            'context' =>  \context_course::instance($invitation->courseid),
            'objectid' => $invitation->courseid,
            'other'=>(array) $invitation
        );
        
        (!isloggedin() or isguestuser()) && $invitation->userid?$data['userid']= $invitation->userid:null;
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
