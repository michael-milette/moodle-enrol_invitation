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

IMPORTANT: This STABLE release has been tested on many Moodle sites. Although we expect everything to work, if you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/moodle-enrol_invitation/issues).

## Setup

1. Add the invitation plug-in to the course by going to "Course administration > Users > Enrolment methods".
2. Next to "Add method" select "Invitation".
3. Make sure "Allow invitations" is set to "Yes" and then click "Add method".

## Invitation process

Once the invitation enrollment plug-in is added, invitations can be sent by doing the following:

1. Go to "Course administration > Users > Enrolled users".
2. Click on "Invite user".
3. Choose a role you want to invite someone as, then enter in their email address. You may optionally change the subject or add a custom message. Then click on "Invite user".
4. The invitation will be sent. The invitation will expire, by default, in 2 weeks. You can check the status of the invite by clicking on the "Invite history" tab.
5. Depending on the status of the invitation, you might have the following actions:
	* "Revoke invite": Will set the expiration of an active invitation to the current time. This will disable the use of the invitation link sent to the user.
	* "Extend invite": Will resent the invitation and update the expiration of an active invitation to 2 weeks from now.
	* "Resend invite": For an expired invitation, will prefill the invitation form with the same settings used when the original invite was sent.

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

TODO

# FAQ

TODO

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

Copyright © 2021 TNG Consulting Inc. - https://www.tngconsulting.ca/

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
