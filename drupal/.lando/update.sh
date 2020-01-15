#!/bin/bash
set -exu

# Update database & enable dev components.

# Set Drush aliases.
local=@tapahtumat.local

# Apply any database updates required.
drush "$local" updb -y

# https://www.drupal.org/project/drupal/issues/3026229#comment-13272349
drush "$local" pmu dblog
drush "$local" cr
drush "$local" pm:enable dblog

drush "$local" en update devel stage_file_proxy -y
drush "$local" config-set stage_file_proxy.settings origin "https://tapahtumat.pori.fi" -y
drush "$local" cr
drush "$local" uli
