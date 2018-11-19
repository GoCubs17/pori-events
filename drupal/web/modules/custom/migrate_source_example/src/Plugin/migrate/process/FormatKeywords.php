<?php

/**
 * @file
 * Contains \Drupal\migrate_source_example\Plugin\migrate\process\FormatKeywords.
 */

namespace Drupal\migrate_source_example\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * @MigrateProcessPlugin(
 *   id = "format_keywords",
 * )
 */
class FormatKeywords extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (!is_string($value)) {
      throw new MigrateException('Expected keyword data is in incorrect format.');
    }

    return $value;
  }
}
