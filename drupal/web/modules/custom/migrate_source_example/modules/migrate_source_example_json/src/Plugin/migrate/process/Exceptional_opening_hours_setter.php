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
 *   id = "exceptional_opening_hours_setter",
 * )
 */
class Exceptional_opening_hours_setter extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Return array of start value and end value.
    if (is_array($value) && !empty($value['date'])) {
      $times['value'] = $value['date'] . 'T' . $value['start_hour'] . ':00';
      $times['end_value'] = $value['date'] . 'T' . $value['end_hour'] . ':00';
      return $times;
    }
    return;
  }
}
