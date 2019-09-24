#!/bin/bash
crond
supervisord --pidfile /run/supervisord.pid
php-fpm -D
nginx
