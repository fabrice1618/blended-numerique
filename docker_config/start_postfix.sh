#!/bin/bash
/etc/init.d/postfix start
php /app/sendmail.php
#tail -f /etc/hostname