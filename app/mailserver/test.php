<?php

$to      = 'fabrice1618@gmail.com';
$subject = 'Test message';
$message = 'hello world';
$headers = array(
    'From' => 'webmaster@top-security.mips.science',
    'Reply-To' => 'webmaster@top-security.mips.science',
    'X-Mailer' => 'BogoMail 1.15'
);

mail($to, $subject, $message, $headers);