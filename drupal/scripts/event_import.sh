#!/bin/sh
# This file manages event node import and cleanup.
/usr/lib/composer/vendor/bin/drush --root=/var/www/pori-events.${WKV_SITE_ENV}.wunder.io/current/web migrate:import --group=migrate_source_event --update > /var/log/drush_cron_temp.log 2>&1
/usr/lib/composer/vendor/bin/drush --root=/var/www/pori-events.${WKV_SITE_ENV}.wunder.io/current/web migrate:rollback --group=migrate_source_event --missing-from-source >> /var/log/drush_cron_temp.log 2>&1

cat /var/log/drush_cron_temp.log | systemd-cat -p info

cat /dev/null > /var/log/drush_cron_temp.log
