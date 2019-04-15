<?php

/**
 * @file
 * Contains \Drupal\migrate_source_example\Plugin\migrate\process\Extra_offers_parse.
 */

namespace Drupal\migrate_source_example_json\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * @MigrateProcessPlugin(
 *   id = "pre_registration_setter",
 * )
 */
class Pre_registration_setter extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Return 1 if pre_registration is set.
    $source_pre_registration = $row->getSource()['pre_registration'];
    $return_boolean = 0;

    if(empty($source_pre_registration)) {
      // If no extra options then return 0
      return $return_boolean;
    }

    return 1;
  }
}
