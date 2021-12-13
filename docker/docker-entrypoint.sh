#!/bin/sh

chmod -R 777 storage/

# The first time volumes are mounted, the project needs to be recreated
if [ ! -d vendor ]; then
    chmod 775 -R vendor/
fi

if [ "$XDEBUG" = true ]; then
    echo "Enabling XDEBUG"
    # Enable XDEBUG
    ln -sf /usr/local/etc/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
    ln -sf /var/www/docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
else
  # Disable XDEBUG
  if [ -e /usr/local/etc/php/conf.d/xdebug.ini ]; then
        rm -f /usr/local/etc/php/conf.d/xdebug.ini
  fi
  if [ -e /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
        rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi
fi

# start apache in background
apachectl restart

if ! [ -f /etc/redis-was-configured ]; then
  redis-server --daemonize yes && sleep 1
  touch /etc/redis-was-configured
fi

redis-server

## Tail web logs to keep container running
tail -F /var/log/apache2/*.log
