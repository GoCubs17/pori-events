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
 *   id = "timeframe_of_day_setter",
 *   handle_multiples = TRUE
 * )
 */
class Timeframe_of_day_setter extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Return 0 if morning, 1 with afternoon and 2 with evening. Field is mapped list of these 3 values.
    if (is_array($value) && !empty($value['start_hour'])) {
      $start_hour_int = (int)substr($value['start_hour'], 0, 2);
      if ($start_hour_int < 12) {
        return 0;
      }
      else if ($start_hour_int < 16 ) {
        return 1;
      }
      else {
        return 2;
      }

    }
    return;
  }
}
