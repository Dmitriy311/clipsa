#!/bin/sh

echo '['$(date '+%d/%m/%Y %H:%M:%S')'] launching php-fpm83...'
php-fpm83
while ! pidof php-fpm83 >> /dev/null ;
  do sleep 3
     echo '...'
  done
echo 'php-fpm is up!'

echo '['$(date '+%d/%m/%Y %H:%M:%S')'] launching nginx...'
nginx
while ! pidof nginx >> /dev/null ;
  do sleep 3
     echo '...'
  done
echo 'nginx is up!'

echo '['$(date '+%d/%m/%Y %H:%M:%S')'] launching smtpd...'
smtpd
while ! pidof smtpd >> /dev/null ;
  do sleep 3
     echo '...'
  done
echo 'smtpd is up!'

echo '['$(date '+%d/%m/%Y %H:%M:%S')'] changing umask for /bitrix...'
chmod -R 777 /bitrix/
echo '['$(date '+%d/%m/%Y %H:%M:%S')'] done'

echo "192.168.0.101    localhost" >> /etc/hosts

while true; do sleep 1000; done