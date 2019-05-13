<?php

/**
 * @file
 * Contains \Drupal\migrate_source_example\Plugin\migrate\process\LinkUrlExternal.
 */

namespace Drupal\migrate_source_example\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin makes sure the external links have protocol
 * (and do not crash drupal when rendering the link)
 *
 * @MigrateProcessPlugin(
 *   id = "link_url_external",
 * )
 */
class LinkUrlExternal extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Make sure external links have a protocol.
    if ($value != '' && strpos($value, 'http') !== 0) {
      $value = 'http://' . $value;
    }

    return $value;
  }

}
