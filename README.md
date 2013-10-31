# Invitation Enrollment Plug-in

The Invitation Enrollment plug-in for Moodle allows instructor to invite
students to their site and grant necessary access and role to them.

## Download

Visit the [GitHub page for the Invitation Enrolment plug-in](https://github.com/ucla/moodle-enrol_invitation) to download the package.

To clone the package into your organization's own repository from the command
line, clone the plug-in repository into your own Moodle install folder by 
doing the following at your Moodle root directory:

    $ git clone https://github.com/ucla/moodle-enrol_invitation enrol/invitation
    
Or download the files as a zipped file in the [releases section on GitHub](https://github.com/ucla/moodle-enrol_invitation/releases).

## Installation

1. If you downloaded the plugin as a zipped file, then add the plugin into the /enrol/invitation directory of your Moodle install.
2. Log into Moodle as administrator.  Go to "Site administration > Notifications" to install the plugin.
3. Then enable the invitation plug-in by going to "Site administration > Plugins > Enrolments > Manage enrol plugins" and clicking on the "eye" icon.

## Features

With this enrollment plugin, instructor can invite and grant access to users to
their course and site.  The invitation is sent via email that contains a link
with an unique, one-time use invitation token. 

When the user clicks on the link and login to the site, (s)he is automatically
enrolled into the course and the invitation link is marked as used.

The benefits of using this plug-in over an enrollment key are:

* You can control who can use the invitation.
* You can see a history of past invitations and their status. 
* You can also see who used an invitation or which ones are expired. 
* You can resend expired invitations or send reminder invitations.

## How to use this tool

### Setup

1. Add the invitation plug-in to the course by going to "Course administration > Users > Enrolment methods".
2. Next to "Add method" select "Invitation".
3. Make sure "Allow invitations" is set to "Yes" and then click "Add method".

### Invitation process

Once the invitation enrollment plug-in is added, invitations can be sent by
doing the following:

1. Go to "Course administration > Users > Enrolled users".
2. Click on "Invite user".
3. Choose a role you want to invite someone as, then enter in their email address. You may optionally change the subject or add a custom message. Then click on "Invite user".
4. The invitation will be sent. The invitation will expire, by default, in 2 weeks. You can check the status of the invite by clicking on the "Invite history" tab.
5. Depending on the status of the invitation, you might have the following actions:
	* "Revoke invite": Will set the expiration of an active invitation to the current time. This will disable the use of the invitation link sent to the user.
	* "Extend invite": Will resent the invitation and update the expiration of an active invitation to 2 weeks from now.
	* "Resend invite": For an expired invitation, will prefill the invitation form with the same settings used when the original invite was sent.
	
## Credit

* [Jerome Mouneyrac](http://www.moodleitandme.com) for his work on the original [invitation enrollment plug-in](https://github.com/mouneyrac/moodle-enrol_invitation) in which this one is based upon.
* The staff, faculty, and students at the University of California, Los Angeles (UCLA) that were involved in creating the additional use cases, development, and refinement to make the tool as it is today.
