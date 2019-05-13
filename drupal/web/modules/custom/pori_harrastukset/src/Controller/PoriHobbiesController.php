<?php

namespace Drupal\pori_harrastukset\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PoriHobbiesController.
 */
class PoriHobbiesController extends ControllerBase {

  /**
   * Hobbiespage.
   *
   * @return string
   *   Return Hello string.
   */
  public function hobbiesPage() {
    return [
      '#type' => 'markup',
      '#markup' => '',
    ];
  }

}
