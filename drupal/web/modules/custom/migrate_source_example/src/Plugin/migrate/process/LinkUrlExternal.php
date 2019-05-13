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
    if(preg_match('/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/', $value)) {
      print_r('No protocol: ');
      $value = 'http://' . $value;
    }

    print_r($value);
    print("\n");

    return $value;
  }

}
