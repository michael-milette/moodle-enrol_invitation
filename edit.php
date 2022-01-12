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
 * Adds new instance of enrol_invitation or edits current instance.
 *
 * @package    enrol_invitation
 * @copyright  2021-2022 TNG Consulting Inc. {@link http://www.tngconsulting.ca}
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @author     Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('edit_form.php');

$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT); // Instanceid.

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id);

require_login($course);
require_capability('enrol/invitation:config', $context);

$PAGE->set_url('/enrol/invitation/edit.php', array('courseid' => $course->id, 'id' => $instanceid));
$PAGE->set_pagelayout('admin');

$return = new moodle_url('/enrol/instances.php', array('id' => $course->id));
if (!enrol_is_enabled('invitation')) {
    redirect($return);
}

$plugin = enrol_get_plugin('invitation');

if ($instanceid) {
    $instance = $DB->get_record('enrol',
            array('courseid' => $course->id, 'enrol' => 'invitation', 'id' => $instanceid), '*', MUST_EXIST);
    $instance->customtext1 = array('text' => $instance->customtext1);
    $instance->role_group['customint2'] = $instance->customint2;
} else {
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', array('id' => $course->id)));
    $instance = new stdClass();
    $instance->id = null;
    $instance->courseid = $course->id;
}

$mform = new enrol_invitation_edit_form(null, array($instance, $plugin, $context),
        'post', '', array('class' => 'mform-invite'));
$mform->set_data($instance);

if ($mform->is_cancelled()) {
    redirect($return);
} else if ($data = $mform->get_data()) {
    if ($instance->id) {
        $instance->status = $data->status;
        $instance->name = $data->name;
        $instance->customint1 = $data->customint1;
        $instance->customint2 = property_exists($data, "role_group") ? $data->role_group['customint2'] : 5;
        $instance->customtext1 = $data->customtext1['text'];
        $instance->customchar1 = $data->customchar1;
        $instance->customint3 = property_exists($data, "customint3") ? $data->customint3 : 0;
        $instance->customint4 = property_exists($data, "customint4") ? $data->customint4 : 0;
        $instance->customint5 = $data->customint5;
        $instance->customint6 = $data->customint6;
        $instance->timemodified = time();
        $DB->update_record('enrol', $instance);
    } else {
        $fields = array('status' => $data->status,
            'name' => $data->name, 'customint5' => $data->customint5, 'customint6' => $data->customint6);
        if ($data->customint1 == 1) {
            $fields['customint1'] = $data->customint1;
            $fields['customint2'] = property_exists($data, "role_group") ? $data->role_group['customint2'] : 5;
            $fields['customtext1'] = $data->customtext1['text'];
            $fields['customchar1'] = $data->customchar1;
            $fields['customint3'] = property_exists($data, "customint3") ? $data->customint3 : 0;
            $fields['customint4'] = property_exists($data, "customint4") ? $data->customint4 : 0;
        }

        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_invitation'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_invitation'));
$mform->display();
echo $OUTPUT->footer();
