Invitation Enrolment Moodle Plugin
==================================

Features
--------

With this enrolment plugin, teacher will be able to send personal invitation to some users by email. Each email contains a link with an invitation token with unique usage. 
When the user clicks on the link, (s)he needs to login/create an account, then (s)he is automatically enrolled into the course. (S)he is assigned a default role. The default role can be changed in the enrolment instance config page.

Only a limited number of invitations can be sent per course/day. However you can change the limitation. Moreover used invitations are not count.

Installation
------------

1. Add the plugin into /enrol folder.
2. Enable the enrolment plugin and set it up. It is quite similar to other enrolment plugins.

Required Moodle version
-----------------------
Moodle 2.2

Maintenance
-----------
At the moment, I do not maintain backward compatibility with the different Moodle version. 
The reason is that I don't use the plugin anymore. In fact I never personally used it in a production site.
I still have a quick look to it time to time, when someone send a pull request.
You are welcome to do a Pull Request on Github, to report [issues](https://github.com/mouneyrac/enrol_invitation/issues). 
I quickly review patches and if they seem to match a minimum the Moodle standard, I integrate them.

To get a plugin version compatible with older Moodle version, go to [Moodle.og] (https://moodle.org/plugins/pluginversions.php?plugin=enrol_invitation)

Don't forget to [indicate if you use the plugin] (https://github.com/mouneyrac/enrol_invitation/issues/4)
You can also have a look to the [Moodle.org download stats] (https://moodle.org/plugins/stats.php?plugin=enrol_invitation)

Important notices
----------------_
* 02/24/13 - Since 1.1, the require version is Moodle 2.2. This is due to using some new functions like context_course.

Cheers,
Jerome Mouneyrac
