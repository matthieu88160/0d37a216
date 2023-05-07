#! /bin/bash

chown -R www-data: /app/var/log
chown -R www-data: /app/var/cache

su www-data -s /bin/bash -c "/usr/bin/composer install"
