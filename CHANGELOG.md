# Change Log
All notable changes to this project will be documented in this file.

## [2.0.0] - 2022-01-18 (BETA)
### Added
- Initial public re-release on Moodle.org and GitHub by TNG Consulting Inc.
- Fix-8: The default email subject is now customizable.
- Fix-2: Invitation text is now editable in the language customization editor.
- You can now re-send an invite if you accidentally revoke an invitation.
- Ability to customize the default email subject line.
- Many new variables are now available in the email template.
- Anonymous users (no account) can reject the invitation to users without an account. Users with an account will need to login.
- You can only accept invitations if you are logged in with the invited user account. You can no longer accept invitations to others.
- Revoking an invitation is now indicated in the Status column of the History. The date revoked is the date in the Expiration Date column.
- CONTRIBUTING.md.
- CHANGELOG.md.
- composer.json
### Updated
- Fix-21: Removed usage of deprecated get_extra_user_fields() for Moodle 3.11+.
- Fix-19: The Moodle log entries from this plugin are now displayed using strings from the language pack.
- Fix-18: No longer displays Undefined Variable COURSE when using invitations with default values set to No.
- Fix-17: Invitation Acceptance and Rejection failures are now logged.
- Fix-16: The email footer will now include the primary admin's email address if the support email address is not defined.
- Fix-12: Email FROM is now set to primary admin's id if show_from_email is disabled and support email address is not defined.
- Fix-14: The help bubble on the email form now shows a correct preview of the email message body.
- Fix-13: The email footer now supports multiple languages.
- Fix-11: Resend Invite link now prefills invitation form.
- Fix-10: Extend invite link option now works.
- Fix-9: Email address and course name fields are now wider when default values are disabled.
- Fix-7: The default message is now displayed when sending new invitations
- Fixed multi-language issues.
- Improved default email message. Note: You may need to update language strings in other languages.
- Updated .gitignore.
- Multiple fixes for Multi-Language Moodle environments.
- Improved accessibility and RTL language of invitation emails.
- Plugin is now compatible and tested with Moodle 3.9, 3.10 and 3.11.
- Refactored code.
- Removed orphaned strings from language pack.
- FAQ in the documentation.
- Russian (ru) and Dutch (nl) language files are no longer included. They will only be available through Moodle language packs.
- Updated documentation for customizing email messages.
- Updated copyright notice for 2022.
