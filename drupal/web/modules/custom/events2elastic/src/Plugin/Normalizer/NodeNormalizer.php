<?php

namespace Drupal\events2elastic\Plugin\Normalizer;

use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Drupal\Core\Field\FieldItemList;

/**
 * Normalizes / denormalizes Drupal nodes into an array structure good for ES.
 */
class NodeNormalizer extends ContentEntityNormalizer {
  /**
   * The interface or class that this Normalizer supports.
   *
   * @var array
   */
  protected $supportedInterfaceOrClass = ['Drupal\node\Entity\Node'];
  /**
   * Supported formats.
   *
   * @var array
   */
  // protected $format = ['elasticsearch_helper'];

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = []) {
    /** @var \Drupal\node\Entity\Node $object */

    $bundle = $object->bundle();
    // Get the object language.
    $langcode = $object->language()->getId();
    // Common for all bundles.
    $data = [
      'id' => $object->id(),

      'uuid' => $object->uuid(),
      'title' => $object->getTitle(),
      'status' => $object->isPublished(),
      'bundle' => $bundle,
      'created' => $object->getCreatedTime(),
      'url' => $object->url(),
    ];
    if ($bundle == 'event') {
      // area term
      if ($object->field_area->target_id) {
        $term_name = Term::load($object->field_area->target_id)->get('name')->value;
        $data['area'] = $term_name;
      }

      // audience term
      if ($object->field_target_audience->target_id) {
        $term_name = Term::load($object->field_target_audience->target_id)->get('name')->value;
        $data['audience'] = $term_name;
      }

      // type term
      if ($object->field_event_type->target_id) {
        $term_name = Term::load($object->field_event_type->target_id)->get('name')->value;
        $data['event_type'] = $term_name;
      }      

      // Text fields
      $data['description'] = $object->field_description->value;
      $data['short_description'] = $object->field_short_description->value;
      $data['tickets'] = $object->field_tickets->value;

      // boolean fields
      $data['free_enterance'] = $object->field_free_enterance->value;

      // Date fields
      $data['start_time'] = $object->field_start_time->value;
      $data['end_time'] = $object->field_end_time->value;

      // Use image style for field_image
      if($object->hasField('field_image') && !$object->get('field_image')->isEmpty()) {
        $entity_img_id = $object->get('field_image')->first()->getValue()['target_id'];
        $image = \Drupal::entityTypeManager()->getStorage('file')->load($entity_img_id);
        $style = \Drupal::entityTypeManager()->getStorage('image_style')->load('thumbnail');
        $data['image'] = $style->buildUrl($image->getFileUri());
      }
    }
    return $data;
  }

  /**
   * Get a list of translated term names.
   *
   * @param \Drupal\Core\Field\FieldItemList $terms
   *   List of Drupal terms.
   * @param string $langcode
   *   Language code.
   *
   * @return array
   *   List of translated term names.
   */
  private function getTranslatedTermNames(FieldItemList $terms, string $langcode) {
    $term_names = [];
    foreach ($terms as $term) {
      if ($term_entity = Term::load($term->target_id)) {
        $translated_term = \Drupal::service('entity.repository')->getTranslationFromContext($term_entity, $langcode);
        $term_names[] = $translated_term->getName();
      }
    }
    return $term_names;
  }

}
