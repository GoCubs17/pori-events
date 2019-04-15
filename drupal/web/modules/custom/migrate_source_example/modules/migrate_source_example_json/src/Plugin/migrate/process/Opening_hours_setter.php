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
 *   id = "opening_hours_setter",
 * )
 */
class Opening_hours_setter extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Return time frame string into corresponding day of the week field.
    if (is_array($value)) {
      $day = $value['day'];
      $time_string = $value['start_hour'] . '-' . $value['end_hour'];
      if ($destination_property == 'field_weekday_monday' && $day == 0) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_tuesday' && $day == 1) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_wednesday' && $day == 2) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_thursday' && $day == 3) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_friday' && $day == 4) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_saturday' && $day == 5) {
        return $time_string;
      }
      if ($destination_property == 'field_weekday_sunday' && $day == 6) {
        return $time_string;
      }
    }
    return;
  }
}
