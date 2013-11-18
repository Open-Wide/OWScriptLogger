{set-block scope=root variable=subject}{"Fatal error from script %1"|i18n("owscriptlogger/mail/fatal_error",,array($script_identifier|wash))}{/set-block}

{"The following error occurred when running the script %1"|i18n("owscriptlogger/mail/fatal_error",,array($script_identifier|wash))}:

{$message}