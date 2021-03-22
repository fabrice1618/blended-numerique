#!/bin/bash
/etc/init.d/postfix start
php /app/mailserver/sendmail.php
