# bitrix-custom-google-mail

1. Install Swiftmailer is via Composer:
composer require swiftmailer/swiftmailer
http://swiftmailer.org/
 
2. Create Google Apps Script https://script.google.com
    1. Replace code with send_mail.gs
    2. Save
    3. Deploy it as Web-application
    4. Ste access from all in web include anonymous user
    5. Copy url (https://script.google.com/macros/s/<SOME_CODE>/exec)
    6. Place url to class constant SCRIPT_URL
3. Add class SendMail to autoload
4. Place custom_function to your init.php

Send mail via Google Apps Script have a limit on message length 700 symbols.
