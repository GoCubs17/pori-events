#!/bin/bash
set -exu

# Update database & enable dev components.

# Set Drush aliases.
local=@tapahtumat.local

# Apply any database updates required.
drush "$local" updb -y
drush "$local" cim -y
drush "$local" en update devel stage_file_proxy -y
drush "$local" config-set stage_file_proxy.settings origin "https://tapahtumat.pori.fi" -y
drush "$local" cr
drush "$local" uli
