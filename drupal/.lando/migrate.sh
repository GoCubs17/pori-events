#!/bin/bash
set -exu

# This file manages event node import and cleanup.

# Run migrate commands.
drush @tapahtumat.local migrate:import --group=migrate_source_event --update
drush @tapahtumat.local migrate:rollback --group=migrate_source_event --missing-from-source
