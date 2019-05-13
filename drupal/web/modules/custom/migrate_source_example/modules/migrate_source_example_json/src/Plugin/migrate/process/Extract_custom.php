<?php

namespace Drupal\migrate_source_example_json\Plugin\migrate\process;

use Drupal\Component\Utility\NestedArray;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
// This is extract with empty value handling to use default.
/**
 * Extracts a value from an array.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "extract_custom",
 *   handle_multiples = TRUE
 * )
 */
class Extract_custom extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (!is_array($value)) {
      if (isset($this->configuration['default'])) {
        $new_value = $this->configuration['default'];
        return $new_value;
      }
      else {
        throw new MigrateException('Input should be an array.');
      }
    }
    $new_value = NestedArray::getValue($value, $this->configuration['index'], $key_exists);
    if (!$key_exists) {
      if (isset($this->configuration['default'])) {
        $new_value = $this->configuration['default'];
      }
      else {
        throw new MigrateException('Array index missing, extraction failed.');
      }
    }
    return $new_value;
  }

}
