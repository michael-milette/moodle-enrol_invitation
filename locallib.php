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
 * Local library file to include classes and functions used.
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Invitation manager that handles the handling of invitation information.
 *
 * @copyright  2013 UC Regents
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class invitation_manager {

    /**
     * Course id.
     * @var int
     */
    private $courseid = null;

    /**
     * The invitation enrol instance of a course.
     *
     * @var int
     */
    private $enrolinstance = null;

    /**
     * Constant for revoking an active invitation.
     */
    const INVITE_REVOKE = 1;

    /**
     * Constant for extending the expiration time of an active invitation.
     */
    const INVITE_EXTEND = 2;

    /**
     * Constant for resending an expired or revoked invite.
     */
    const INVITE_RESEND = 3;

    /**
     * Constructor.
     *
     * @param int $courseid
     * @param boolean $instancemustexist
     */
    public function __construct($courseid, $instancemustexist = true) {
        $this->courseid = $courseid;
        $this->enrolinstance = $this->get_invitation_instance($courseid, $instancemustexist);
    }

    /**
     * Return HTML invitation menu link for a given course.
     *
     * It's mostly useful to add a link in a block menu - by default icon is
     * displayed.
     *
     * @param boolean $withicon - set to false to not display the icon
     * @return
     */
    public function get_menu_link($withicon = true) {
        global $OUTPUT;

        $inviteicon = '';
        $link = '';

        if (has_capability('enrol/invitation:enrol', context_course::instance($this->courseid))) {

            // Display an icon with requested (css can be changed in stylesheet).
            if ($withicon) {
                $inviteicon = html_writer::empty_tag('img', array('alt' => "invitation", 'class' => "enrol_invitation_item_icon",
                            'title' => "invitation", 'src' => $OUTPUT->pix_url('invite', 'enrol_invitation')));
            }

            $link = html_writer::link(
                            new moodle_url('/enrol/invitation/invitation.php',
                                    array('courseid' => $this->courseid)), $inviteicon . get_string('inviteusers',
                                    'enrol_invitation'));
        }

        return $link;
    }

    /**
     * Send invitation (create a unique token for each of them).
     *
     * @param array $data       data processed from the invite form, or an invite
     * @param bool $resend     resend the invite specified by $data
     */
    public function send_invitations($data, $resend = false) {
        global $DB, $CFG, $SITE, $USER;

        if (has_capability('enrol/invitation:enrol', context_course::instance($data->courseid))) {

            // Get course record, to be used later.
            $course = $DB->get_record('course', array('id' => $data->courseid), '*', MUST_EXIST);
            if (!empty($data->email)) {

                // Create a new token only if we are not resending an active invite.
                if ($resend) {
                    $token = $data->token;
                } else {
                    // Create unique token for invitation.
                    do {
                        $token = uniqid();
                        $existingtoken = $DB->get_record('enrol_invitation', array('token' => $token));
                    } while (!empty($existingtoken));
                }

                // Save token information in config (token value, course id, TODO: role id).
                $invitation = new stdClass();
                $invitation->email = $data->email;
                $invitation->courseid = $data->courseid;
                $invitation->token = $token;
                $invitation->tokenused = false;
                $invitation->roleid = $resend ? $data->roleid : $data->role_group['roleid'];

                // Set time.
                $timesent = time();
                $invitation->timesent = $timesent;
                $invitation->timeexpiration = $timesent +
                        get_config('enrol_invitation', 'inviteexpiration');

                // Update invite to have the proper timesent/timeexpiration.
                if ($resend) {
                    $DB->set_field('enrol_invitation', 'timeexpiration', $invitation->timeexpiration,
                            array('courseid' => $data->courseid, 'id' => $data->id));

                    // Prepend subject heading with a 'Reminder' string.
                    $invitation->subject = get_string('reminder', 'enrol_invitation');
                }

                if (empty($invitation->subject)) {
                    $invitation->subject = $data->subject;
                } else {
                    $invitation->subject .= $data->subject;
                }

                $invitation->inviterid = $USER->id;
                $invitation->notify_inviter = empty($data->notify_inviter) ? 0 : 1;
                $invitation->show_from_email = empty($data->show_from_email) ? 0 : 1;

                // Construct message: custom (if any) + template.

                $message = '';

                $message_params = new stdClass();
                if ($location = $DB->get_record('course_format_options', array('courseid' => $course->id, 'format' => 'event', 'name' => 'location'))) {
                    $message_params->location = $location->value;
                } else {
                    $message_params->location = "";
                }
                $message_params->fullname = $course->fullname;
                $message_params->start = userdate($course->startdate, "%d-%m-%Y %I:%M %p");
                $message_params->end = userdate($course->enddate,"%d-%m-%Y %I:%M %p");

                $message_params->expiration = userdate($invitation->timeexpiration, "%d-%m-%Y %I:%M %p");
                $inviteurl = new moodle_url('/enrol/invitation/enrol.php',
                        array('token' => $token));

                $rejecturl = new moodle_url('/enrol/invitation/enrol.php',
                        array('token' => $token, 'reject'=>1));

                $message_params->inviteurl = $inviteurl->out(false);
                $message_params->rejecturl = $rejecturl->out(false);
                $message_params->supportemail = $CFG->supportemail;
                $message_params->supportemailtext = get_string('emailmsgunsubscribe', 'enrol_invitation', $message_params);
                $message_params->acceptinvitation = get_string('invitationacceptancebutton', 'enrol_invitation');
                $message_params->rejectinvitation = get_string('invitationrejectbutton', 'enrol_invitation');

                $message .= get_string('emailmsgtxt', 'enrol_invitation', $message_params);

                $message_params->message = $message;
                $invitation->message = "";
                $invitation->timeused = null;

                if (!empty($data->message['text'])) {
                    $message .= get_string('instructormsg', 'enrol_invitation',
                            $data->message['text']);

                    $invitation->message = get_string('instructormsg', 'enrol_invitation',
                            $data->message['text']);
                }

                $messagehtml = $this->generate_html_message($invitation, $message_params);

                // Change FROM to be $CFG->supportemail if user has show_from_email off.
                $fromuser = $USER;
                if (empty($invitation->show_from_email)) {
                    $fromuser = $DB->get_record('user', array('id' => 2));
                    $fromuser->email = $CFG->supportemail;
                    $fromuser->maildisplay = true;
                    $fromuser->sender = $USER;
                }
                $userexits = false;
                //check if user exists
                if ($contactuser = $DB->get_record('user', array('email' => $invitation->email))) {
                    $contactuser->mailformat = 1;
                    $contactuser->maildisplay = true;
                    $invitation->userid = $contactuser->id;
                    $userexits = true;
                } else {
                    // Send invitation to the user.
                    $contactuser = new stdClass();
                    $contactuser->id = -1; // required by new version of email_to_user since moodle 2.6
                    $contactuser->email = $invitation->email;
                    $contactuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
                    $contactuser->firstname = '';
                    $contactuser->lastname = '';
                    $contactuser->maildisplay = true;
                    $contactuser->firstnamephonetic = '';
                    $contactuser->lastnamephonetic = '';
                    $contactuser->middlename = '';
                    $contactuser->alternatename = '';
                }

                if ($userexits && !is_enrolled(context_course::instance($invitation->courseid), $contactuser)&&$this->check_invitation_rejected($invitation->userid,$invitation->courseid) || $userexits == false) {
                    if (!$resend && ($data->registeredonly != 1 || $data->registeredonly == 1 && $userexits == true)) {
                        $invitation->id = $DB->insert_record('enrol_invitation', $invitation);
                        email_to_user($contactuser, $fromuser, $invitation->subject, $message, $messagehtml);
                    }
                    $userexits ? "" : $invitation->userid = -1;
                    // Log activity after sending the email.
                    if ($resend) {
                        \enrol_invitation\event\invitation_updated::create_from_invitation($invitation)->trigger();
                    } elseif ($data->registeredonly != 1 || $data->registeredonly == 1 && $userexits == true && $invitation->status != "rejected") {
                        \enrol_invitation\event\invitation_sent::create_from_invitation($invitation)->trigger();
                    } else {
                        $invitation->id = 0;
                        \enrol_invitation\event\invitation_notsent::create_from_invitation($invitation)->trigger();
                    }
                }
            }
        } else {
            throw new moodle_exception('cannotsendinvitation', 'enrol_invitation',
                    new moodle_url('/course/view.php', array('id' => $data['courseid'])));
        }
    }

    /**
     * Checks if user who accepted invite has an access expiration for their
     * enrollment.
     *
     * @param object $invite    Database record
     *
     * @return string           Returns expiration string. Blank if no
     *                          restriction.
     */
    public function get_access_expiration($invite) {
        $expiration = '';

        if (empty($invite->userid)) {
            return $expiration;
        }

        // Check to see if user has a time restriction on their access.
        $timeend = enrol_get_enrolment_end($invite->courseid, $invite->userid);
        if ($timeend === false) {
            // No active enrollment now.
            $expiration = get_string('status_invite_used_noaccess', 'enrol_invitation');
        } else if ($timeend > 0) {
            // Access will end on a certain date.
            $expiration = get_string('status_invite_used_expiration',
                    'enrol_invitation', date('M j, Y', $timeend));
        }
        return $expiration;
    }

    /**
     * Returns status of given invite.
     *
     * @param object $invite    Database record
     *
     * @return string           Returns invite status string.
     */
    public function get_invite_status($invite) {
        if (!is_object($invite)) {
            return get_string('status_invite_invalid', 'enrol_invitation');
        }

        // TO DO redefinition for statuses storing in enrol_invitation history
        if(is_null($invite->status)){
          if ($invite->tokenused) {
            // Invite was used already.
            $status = get_string('status_invite_used', 'enrol_invitation');
            return $status;
        } else if ($invite->timeexpiration < time()) {
            // Invite is expired.
            return get_string('status_invite_expired', 'enrol_invitation');
        } else {
            return get_string('status_invite_active', 'enrol_invitation');
        }
        }
        else{
          return get_string('status_invite_'.$invite->status, 'enrol_invitation');
        }

        // TO DO: add status_invite_revoked and status_invite_resent status.
    }

    /**
     * Return all invites for given course.
     *
     * @param int $courseid
     * @return array
     */
    public function get_invites($courseid = null) {
        global $DB;

        if (empty($courseid)) {
            $courseid = $this->courseid;
        }

        $invites = $DB->get_records('enrol_invitation', array('courseid' => $courseid));

        return $invites;
    }

    /**
     * Return the invitation instance for a specific course.
     *
     * Note: as using $PAGE variable, this function can only be called in a
     * Moodle script page.
     *
     * @param int $courseid
     * @param boolean $mustexist when set, an exception is thrown if no instance is found
     * @return object
     */
    public function get_invitation_instance($courseid, $mustexist = false) {
        global $PAGE, $CFG, $DB;

        if (($courseid == $this->courseid) and!empty($this->enrolinstance)) {
            return $this->enrolinstance;
        }

        // Find enrolment instance.
        $instance = null;
        require_once("$CFG->dirroot/enrol/locallib.php");
        $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
        $manager = new course_enrolment_manager($PAGE, $course);
        foreach ($manager->get_enrolment_instances() as $tempinstance) {
            if ($tempinstance->enrol == 'invitation') {
                if ($instance === null) {
                    $instance = $tempinstance;
                }
            }
        }

        if ($mustexist and empty($instance)) {
            throw new moodle_exception('noinvitationinstanceset', 'enrol_invitation');
        }

        return $instance;
    }

    /**
     * Enrol the user following the invitation data.
     * @param object $invitation
     */
    public function enroluser($invitation) {
        global $USER, $DB;

        // Handle daysexpire by adding making the enrollment expiration be the
        // end of the day after daysexpire days.
        $timeend = 0;
        if (!empty($invitation->daysexpire)) {
            // Get today's date as a timestamp. Ignore the current time.
            $today = strtotime(date('Y/m/d'));
            // Get the day in the future.
            $timeend = strtotime(sprintf('+%d days', $invitation->daysexpire), $today);
            // But make sure the timestamp is for the end of that day. Remember
            // that 86400 is the total seconds in a day. So -1 that is right
            // before midnight.
            $timeend += 86399;
        }
        if ((!isloggedin() or isguestuser()) && $invitation->userid) {
            $user = $DB->get_record('user', array('id' => $invitation->userid));
        } elseif (isloggedin()) {
            $user = $USER;
        } else {
            $notice_object = prepare_notice_object($invitation);
            throw new moodle_exception('loggedinnot', 'enrol_invitation', $notice_object);
        }

        $enrol = enrol_get_plugin('invitation');
        $enrol->enrol_user($this->enrolinstance, $user->id,
                $invitation->roleid, 0, $timeend);
    }

    /**
     * Figures out who used an invite.
     *
     * @param object $invite    Invitation record
     *
     * @return object           Returns an object with following values:
     *                          ['username'] - name of who used invite
     *                          ['useremail'] - email of who used invite
     *                          ['roles'] - roles the user has for course that
     *                                      they were invited
     *                          ['timeused'] - formatted string of time used
     *                          Returns false on error or if invite wasn't used.
     */
    public function who_used_invite($invite) {
        global $DB;
        $ret_val = new stdClass();

        if (empty($invite->userid) || empty($invite->tokenused) ||
                empty($invite->courseid) || empty($invite->timeused)) {
            return false;
        }

        // Find user.
        $user = $DB->get_record('user', array('id' => $invite->userid));
        if (empty($user)) {
            return false;
        }
        $ret_val->username = sprintf('%s %s', $user->firstname, $user->lastname);
        $ret_val->useremail = $user->email;

        // Find their roles for course.
        $ret_val->roles = get_user_roles_in_course($invite->userid, $invite->courseid);
        if (empty($ret_val->roles)) {
            // If no roles, then they must have been booted out later.
            return false;
        }
        $ret_val->roles = strip_tags($ret_val->roles);

        // Format string when invite was used.
        $ret_val->timeused = date('M j, Y g:ia', $invite->timeused);

        return $ret_val;
    }

    public function generate_html_message($invitation, $messageparams) {
        $htmlmail = "<!doctype html>
  <html>
  <head>
    <meta name=\"viewport\" content=\"width=device-width\" />
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <title>{$invitation->subject}</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */

      /*All the styling goes here*/

      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%;
      }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
      }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 12px;
          vertical-align: top;
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%;
      }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 800px;
        padding: 10px;
        width: 1024px;
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 800px;
        padding: 10px;
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%;
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px;
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%;
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 10px;
          text-align: center;
      }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px;
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize;
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 15px;
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px;
      }

      a {
        color: #3498db;
        text-decoration: underline;
      }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto;
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center;
      }
        .btn a {
          background-color: #ffffff;
          border: 1px solid #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize;
      }

      .btn-primary table td {
        background-color: #3498db;
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff;
      }

      .btn-danger table td {
        background-color: #dc3545;
      }

      .btn-danger a {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
      }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0;
      }

      .first {
        margin-top: 0;
      }

      .align-center {
        text-align: center;
      }

      .align-right {
        text-align: right;
      }

      .align-left {
        text-align: left;
      }

      .clear {
        clear: both;
      }

      .mt0 {
        margin-top: 0;
      }

      .mb0 {
        margin-bottom: 0;
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0;
      }

      .powered-by a {
        text-decoration: none;
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0;
      }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important;
        }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important;
        }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important;
        }
        table[class=body] .content {
          padding: 0 !important;
        }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important;
        }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important;
        }
        table[class=body] .btn table {
          width: 100% !important;
        }
        table[class=body] .btn a {
          width: 100% !important;
        }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important;
        }
      }

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%;
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important;
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important;
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important;
        }
      }

    </style>
  </head>
  <body class=\"\">
    <span class=\"preheader\">{$invitation->subject}</span>
    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">
      <tr>
        <td>&nbsp;</td>
        <td class=\"container\">
          <div class=\"content\">

            <!-- START CENTERED WHITE CONTAINER -->
            <table role=\"presentation\" class=\"main\">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class=\"wrapper\">
                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                      <td>
                        {$messageparams->message}
                        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"btn btn-primary\">
                          <tbody>
                            <tr>
                              <td align=\"left\">
                                <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                  <tbody>
                                    <tr>
                                      <td class=\"btn\"><a href=\"{$messageparams->inviteurl}\" class=\"btn btn-primary\">{$messageparams->acceptinvitation}</a></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"btn btn-danger\">
                          <tbody>
                            <tr>
                              <td align=\"left\">
                                <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                  <tbody>
                                    <tr>
                                      <td class=\"btn\"><a href=\"{$messageparams->rejecturl}\" class=\"btn btn-danger\">{$messageparams->rejectinvitation}</a></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        {$invitation->message}
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->

            <!-- START FOOTER -->
            <div class=\"footer\">
              <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <tr>
                  <td class=\"content-block\">
                    <span class=\"apple-link\">If you believe that you have received this message in error or are in need of
                                               assistance, please contact:</span>
                    <br><a href=\"mailto:{$messageparams->supportemail}\">{$messageparams->supportemail}</a>.
                  </td>
                </tr>
                <tr>
                  <td class=\"content-block powered-by\">

                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
  </html>";
        return $htmlmail;
    }

    public function check_invitation_rejected($userid,$courseid){
      global $DB;
      if ($DB->get_record('enrol_invitation',array('course'=>$courseid,'userid'=>$userid,'status'=>"rejected"))){
        return true;
      }else {return false;}
    }
}

/**
 * Reports the approximate distance in time between two times given in seconds
 * or in a valid ISO string like.
 *
 * For example, if the distance is 47 minutes, it'll return
 * "about 1 hour". See the source for the complete wording list.
 *
 *  Integers are interpreted as seconds. So,
 * <tt>$date_helper->distance_of_time_in_words(50)</tt> returns "less than a minute".
 *
 * Set <tt>include_seconds</tt> to true if you want more detailed approximations if distance < 1 minute
 *
 * Code borrowed/inspired from:
 * http://www.8tiny.com/source/akelos/lib/AkActionView/helpers/date_helper.php.source.txt
 *
 * Which was in term inspired by Ruby on Rails' similarly called function.
 *
 * @param int $from_time
 * @param int $to_time
 * @param boolean $include_seconds
 * @return string
 */
function distance_of_time_in_words($from_time, $to_time = 0, $include_seconds = false) {
    $from_time = is_numeric($from_time) ? $from_time : strtotime($from_time);
    $to_time = is_numeric($to_time) ? $to_time : strtotime($to_time);
    $distance_in_minutes = round((abs($to_time - $from_time)) / 60);
    $distance_in_seconds = round(abs($to_time - $from_time));

    if ($distance_in_minutes <= 1) {
        if ($include_seconds) {
            if ($distance_in_seconds < 5) {
                return get_string('less_than_x_seconds', 'enrol_invitation', 5);
            } else if ($distance_in_seconds < 10) {
                return get_string('less_than_x_seconds', 'enrol_invitation', 10);
            } else if ($distance_in_seconds < 20) {
                return get_string('less_than_x_seconds', 'enrol_invitation', 20);
            } else if ($distance_in_seconds < 40) {
                return get_string('half_minute', 'enrol_invitation');
            } else if ($distance_in_seconds < 60) {
                return get_string('less_minute', 'enrol_invitation');
            } else {
                return get_string('a_minute', 'enrol_invitation');
            }
        }
        return ($distance_in_minutes == 0) ? get_string('less_minute', 'enrol_invitation') : get_string('a_minute', 'enrol_invitation');
    } else if ($distance_in_minutes <= 45) {
        return get_string('x_minutes', 'enrol_invitation', $distance_in_minutes);
    } else if ($distance_in_minutes < 90) {
        return get_string('about_hour', 'enrol_invitation');
    } else if ($distance_in_minutes < 1440) {
        return get_string('about_x_hours', 'enrol_invitation', round($distance_in_minutes / 60));
    } else if ($distance_in_minutes < 2880) {
        return get_string('a_day', 'enrol_invitation');
    } else {
        return get_string('x_days', 'enrol_invitation', round($distance_in_minutes / 1440));
    }
}

/**
 * Setups the object used in the notice strings for when a user is accepting
 * a site invitation.
 *
 * @param object $invitation
 * @return object
 */
function prepare_notice_object($invitation) {
    global $CFG, $course, $DB;

    $noticeobject = new stdClass();
    $noticeobject->email = $invitation->email;
    $noticeobject->coursefullname = $course->fullname;
    $noticeobject->supportemail = $CFG->supportemail;

    // Get role name for use in acceptance message.
    //role name is no longer defined in `role` table. It is scattered around database.
    $context = context_course::instance($course->id);
    $roles = get_default_enrol_roles($context); //fetching roles using API
    if (array_key_exists($invitation->roleid, $roles)) {
        //Normally we should have roles here
        $noticeobject->rolename = $roles[$invitation->roleid];
    } else {
        //In case something gone wrong we will do this the old way
        $role = $DB->get_record('role', array('id' => $invitation->roleid));
        $noticeobject->rolename = $role->name; //empty in new Moodle versions
        // role description is not used anywhere in plugin
        // and is also empty in new Moodle versions
        $noticeobject->roledescription = strip_tags($role->description);
    }
    return $noticeobject;
}

/**
 * Prints out tabs and highlights the appropiate current tab.
 *
 * @param string $active_tab  Either 'invite' or 'history'
 */
function print_page_tabs($active_tab) {
    global $CFG, $COURSE;

    $tabs[] = new tabobject('history',
            new moodle_url('/enrol/invitation/history.php',
                    array('courseid' => $COURSE->id)),
            get_string('invitehistory', 'enrol_invitation'));
    $tabs[] = new tabobject('invite',
            new moodle_url('/enrol/invitation/invitation.php',
                    array('courseid' => $COURSE->id)),
            get_string('inviteusers', 'enrol_invitation'));

    // Display tabs here.
    print_tabs(array($tabs), $active_tab);
}