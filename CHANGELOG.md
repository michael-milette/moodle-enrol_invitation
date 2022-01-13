# Change Log
All notable changes to this project will be documented in this file.

## [1.3.1] - 2022-01-13 (DEV-BETA)
### Added
- Initial public re-release on Moodle.org and GitHub by TNG Consulting Inc.
- Fix-8: Default email subject is now customizable.
- Fix-2: Invitation text is now editable in language customization editor.
- Ability to customize the default email subject line.
- Many new variables now available in the email template.
- Anonymous users (no account) can reject invitation to users without an account. Users with an account will need to login.
- You can only accept invitations if you are logged in with the invited user account. You can no longer accept invitations for others.
- Revoking an invitation is now indicated in the status column of the History. The date revoked is the date in the Expiration Date column.
- CONTRIBUTING.md.
- CHANGELOG.md.
- composer.json
### Updated
- Fix-16: Email footer will now include primary admin's email address if support email address is not defined.
- Fix-12: Email FROM is now set to primary admin's id if show_from_email is disabled and support email address is not defined.
- Fix-14: Help bubble on email form now shows correct preview of email message body.
- Fix-13: Email footer now supports multiple languages.
- Fix-10: Extend invite link option now works.
- Fix-9: Email address and course name fields are now wider when default values are disabled.
- Fixed multi-language issues.
- Improved default email message. Note: You may need to update language strings in other languages.
- Updated .gitignore
- Multiple fixes for Multi-Language Moodle environments.
- Improved accessibility and rtl language of invitation emails.
- Plugin now compatible and tested with Moodle 3.9, 3.10 and 3.11.
- Refactored code.
- FAQ in documentation.
- Russian (ru) and Dutch (nl) language files are no longer included. They will only be available through Moodle language packs.
- Updated documentation for customizing email messages.
- Updated copyright notice for 2022.
