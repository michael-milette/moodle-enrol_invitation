<img src="pix/logo.png" align="right" />

Invitation enrollment plugin for Moodle
=======================================
![PHP](https://img.shields.io/badge/PHP-v5.6%20%2F%20v7.0%20%2F%20v7.1%2F%20v7.2%2F%20v7.3%2F%20v7.4-blue.svg)
![Moodle](https://img.shields.io/badge/Moodle-v2.6%20to%20v3.11.x-orange.svg)
[![GitHub Issues](https://img.shields.io/github/issues/michael-milette/moodle-enrol_invitation.svg)](https://github.com/michael-milette/moodle-enrol_invitation/issues)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-green.svg)](#contributing)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](#license)

# Table of Contents

- [Basic Overview](#basic-overview)
- [Requirements](#requirements)
- [Download Invitation for Moodle](#download-invitation-for-moodle)
- [Installation](#installation)
- [Usage](#usage)
    - [Settings](#settings)
- [Updating](#updating)
- [Uninstallation](#uninstallation)
- [Limitations](#limitations)
- [Language Support](#language-support)
- [Troubleshooting](#troubleshooting)
- [Frequently Asked Questions (FAQ)](#faq)
- [Contributing](#contributing)
- [Motivation for this plugin](#motivation-for-this-plugin)
- [Further information](#further-information)
- [License](#license)

# Basic Overview

The Invitation enrollment plug-in for Moodle allows instructor to invite students to their course and site, and grant necessary access and role to them. The invitation is sent via email that contains a link with an unique, one-time use invitation token.

When the user clicks on the link and login to the site, (s)he is automatically enrolled into the course and the invitation link is marked as used.

The benefits of using this plug-in over an enrollment key are:

* You can control who can use the invitation.
* You can see a history of past invitations and their status.
* You can also see who used an invitation or which ones are expired.
* You can resend expired invitations or send reminder invitations.

[(Back to top)](#table-of-contents)

# Requirements

This plugin requires Moodle 2.6+ from https://moodle.org/ .

[(Back to top)](#table-of-contents)

# Download Invitation for Moodle

The most recent STABLE release of Invitation for Moodle is available from:
https://moodle.org/plugins/enrol_invitation

The most recent DEVELOPMENT release can be found at:
https://github.com/michael-milette/moodle-enrol_invitation

This is a fork of the original plugin by Jérôme Mouneyrac. Michael Milette (TNG Consulting Inc.) is the maintainer of this plugin since September 2021.

This version of the Invitation plugin also includes contributions by:
- University of California, Los Angeles (ucla)
- Yuriy Petrovskiy (PetrovskYYY)
- Lukas Celinak (lukascelinak)
- Michael Milette, TNG Consulting Inc. (michael-milette)

See the git log for a full list of contributors.

[(Back to top)](#table-of-contents)

# Installation

Install the plugin, like any other plugin, to the following folder:

    /enrol/invitation

See https://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins.

In order for the enrolment method to be available, the plugin must be installed and enabled.

To enable, go to Site Administration > Plugins > Enrolments > Manage enrol plugins and clicking on the "eye" icon for Invitation.

[(Back to top)](#table-of-contents)

# Usage

IMPORTANT: This BETA release has not been tested on many Moodle sites yet. Although we expect everything to work, if you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/moodle-enrol_invitation/issues).

## Setup

Add the **Invitation** enrolment method to the course.

1. Go to the course.
2. Go to **Course administration > Users > Enrolment methods**.
2. Next to **Add method**, select **Invitation**.
3. Make sure **Allow invitations** is set to **Yes** and then click **Add method**.

See more information on [adding an enrolment method to your course](https://docs.moodle.org/en/Enrolment_methods).

## Customization

You can customize the email being sent in a couple of ways:

### Email template customization

You can modify the message sent by email by navigating to Site Administration > Language Customization. Follow the prompts. The language string to be modified is in the **enrol_invitation** component, specifically the **emailmsghtml_help** string.

Note that you can use any of the following variables within the body of the email message.:

* {$a->coursename} : The course fullname.
* {$a->start} : The course start date.
* {$a->end} : The course end date. If no end date is specified, it will be replaced by **No end date**.
* {$a->inviteurl} : URL of the accept link
* {$a->acceptinvitation} : The words "Accept invitation".
* {$a->rejecturl} : URL of the reject link.
* {$a->rejectinvitation} : The words "Reject invitation".
* {$a->expiration} : The date and time at which these links will expire.
* {$a->message} : Your custom message, as entered at the time you send the invitation.
* {$a->location} : Picked-up from one of the following places: A field called **location** in your course format - only available in some 3rd party course formats, a custom course field called **location**\'**. If neither of these exist, its value will simply be 'online'. Important: These variables cannot be used when setting the default message for an instance of Invitation or when sending the invitation.
* {$a->supportemail} : Support email address for the site.
* {$a->emailmsgunsubscribe} : Unsubscribe/Support message.

Reminder: If you have a multi-language site, you will need to customize the message for each language.

### Additional custom message from the teacher

This is a message that can be customized and will be integrated into the default message template.

### Customize default email subject

You can set the default email subject course name by navigating to Site Administration > Plugins > Enrolment > Invitation. You will find 3 options for the subject line: Course fullname, course shortname and custom.

If you select the **Custom** option, you can customize the **customsubjectformat** language string of the **enrol_invitation** plugin using the Moodle Site Administration > Language > Language Customization tool in Moodle. There you can use any combination of the short and long course names. When this plugin is first installed, the custom format is set to **{$a->shortname} - {$a->fullname}**.

## Invitation process

Once the Invitation enrollment method has been added, invitations can be sent by doing the following:

1. Go to the course and then click on the **Participants** button in the navigation drawer.
2. Go to **Course administration > Users > Enrolled users**.
3. Click on **Invite users** button. It should be located next to the **Enrol users** button. This button may have a different name if you customized it in the course's **Custom instance name** field for this enrolment method.
4. Choose a role you want to invite someone as, then enter in their email address. You may optionally change the subject or add a custom message. Then click on **Invite users**.
5. The invitation will be sent. Note that the invitation will expire, by default, in 2 weeks. You can check the status of the invite by clicking on the **Invite history** tab.
6. Depending on the status of the invitation, you might have the following actions:
	* "Revoke invite": Will set the expiration of an active invitation to the current time. This will disable the use of the invitation link sent to the user.
	* "Extend invite": Will resent the invitation and update the expiration of an active invitation to 2 weeks from now.
	* "Resend invite": For an expired invitation, will pre-fill the invitation form with the same settings used when the original invite was sent.

# Updating

There are no special considerations required for updating the plugin.

[TODO update this information!] The first public ALPHA version was released on 2017-07-07, BETA on 2017-11-11 and STABLE as of 2018-11-26.

For more information on releases since then, see
[CHANGELOG.md](https://github.com/michael-milette/moodle-enrol_invitation/blob/master/CHANGELOG.md).

[(Back to top)](#table-of-contents)

# Uninstallation

Uninstalling the plugin by going into the following:

Home > Administration > Site Administration > Plugins > Manage plugins > Invitation

...and click Uninstall. You may also need to manually delete the following folder:

    /enrol/invitation

Note that, once uninstalled, any tags and content normally handled by this plugin will become visible to all users.

# Limitations

There are no known limitation at this time.

# Language Support

This plugin includes support for the English language. Several translations have been contributed.

If you need a different language that is not yet supported, please feel free to contribute using the Moodle AMOS Translation Toolkit for Moodle at

https://lang.moodle.org/

This plugin has not been tested for right-to-left (RTL) language support. If you want to use this plugin with a RTL language and it doesn't work as-is, feel free to prepare a pull request and submit it to the project page at:

https://github.com/michael-milette/moodle-enrol_invitation

# Troubleshooting

There are no troubleshooting tips at this time.

# FAQ

There are no answers to frequently asked questions yet.

# Contributing

If you are interested in helping, please take a look at our [contributing](https://github.com/michael-milette/moodle-enrol_invitation/blob/master/CONTRIBUTING.md) guidelines for details on our code of conduct and the process for submitting pull requests to us.

## Contributors

Michael Milette - Author and Lead Developer

Big thank you to the following contributors. (Please let me know if I forgot to include you in the list):

* [Jerome Mouneyrac](http://www.moodleitandme.com) for his work on the original [invitation enrollment plug-in](https://github.com/mouneyrac/moodle-enrol_invitation) in which this one is based upon.
* The staff, faculty, and students at the University of California, Los Angeles (UCLA) that were involved in creating the additional use cases, development, and refinement to this tool.

# Motivation for this plugin

The development of this plugin was motivated through our own experience in Moodle development, features requested by out clients and topics discussed in the Moodle forums. The project is sponsored and supported by TNG Consulting Inc.

[(Back to top)](#table-of-contents)

# Further Information

For further information regarding the enrol_invitation plugin, support or to report a bug, please visit the project page at:

https://github.com/michael-milette/moodle-enrol_invitation

[(Back to top)](#table-of-contents)

# License

Copyright © 2021-2022 TNG Consulting Inc. - https://www.tngconsulting.ca/

This file is part of Invitation for Moodle - https://moodle.org/

Invitation is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Invitation is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Invitation.  If not, see <https://www.gnu.org/licenses/>.

[(Back to top)](#table-of-contents)
