# Change Log
All notable changes to this project will be documented in this file.

## [1.3.0] - 2022-01-12 (DEV-BETA)
### Added
- Initial public re-release on Moodle.org and GitHub by TNG Consulting Inc.
- Fix-8: Default email subject is now customizable.
- Fix-2: Invitation text is now editable in language customization editor.
- Ability to customize the default email subject line.
- Many new variables usable in the email template.
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
- Updated documentation for customizing email messages.
- Updated copyright notice for 2022.
