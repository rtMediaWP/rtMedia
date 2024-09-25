#!/bin/bash

if [ "$#" -ne 1 ] || [ "$1" = "off" ]; then
  echo "Xdebug has been turned off, please use the following syntax: 'lando xdebug <mode>'."
  echo "Valid modes: https://xdebug.org/docs/all_settings#mode."
  echo xdebug.mode = off > /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  if [ -f "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" ]; then
    rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  fi
  pkill -o -USR2 php-fpm
else
  mode="$1"
  echo xdebug.mode = "$mode" > /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  if [ ! -f "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" ]; then
  	docker-php-ext-enable xdebug
  fi
  if [[ $mode = *"profile"* ]]; then
    if [ ! -d "$PROFILER_OUTPUT_DIR" ]; then
      mkdir "$PROFILER_OUTPUT_DIR"
      chown $LANDO_HOST_UID:$LANDO_HOST_GID "$PROFILER_OUTPUT_DIR"
    fi
    echo xdebug.output_dir = "/app/$PROFILER_OUTPUT_DIR" >> /usr/local/etc/php/conf.d/zzz-lando-xdebug.ini
  fi
  pkill -o -USR2 php-fpm
  echo "Xdebug is loaded in "$mode" mode."
fi
