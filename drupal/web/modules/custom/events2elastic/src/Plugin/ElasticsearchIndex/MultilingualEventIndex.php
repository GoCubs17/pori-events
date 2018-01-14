<?php

namespace Drupal\events2elastic\Plugin\ElasticsearchIndex;

use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\elasticsearch_helper\ElasticsearchLanguageAnalyzer;
use Drupal\elasticsearch_helper\Plugin\ElasticsearchIndexBase;
use Elasticsearch\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Sets up an Elasticsearch index for Services.
 *
 * @ElasticsearchIndex(
 *   id = "event_index",
 *   label = @Translation("Event Index"),
 *   indexName = "event-node-{langcode}",
 *   typeName = "node",
 *   entityType = "node",
 *   bundle = "event"
 * )
 */
class MultilingualEventIndex extends ElasticsearchIndexBase {
  /**
   * Language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Client $client, Serializer $serializer, LoggerInterface $logger, LanguageManagerInterface $languageManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $client, $serializer, $logger);
    $this->languageManager = $languageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('elasticsearch_helper.elasticsearch_client'),
      $container->get('serializer'),
      $container->get('logger.factory')->get('elasticsearch_helper'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function serialize($source, $context = []) {
    /** @var \Drupal\node\Entity\Node $source */
    $data = parent::serialize($source, $context);
    // Add the language code to be used as a token.
    $data['langcode'] = $source->language()->getId();
    return $data;
  }

  /**
   * Determine the name of the ID for the elasticsearch entry.
   *
   * @return string
   *   The id of the item to be indexed.
   */
  public function getId($data) {
    // Elasticsearch will generate its own id.
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function index($source) {
    /** @var \Drupal\node\Entity\Node $source */
    foreach ($source->getTranslationLanguages() as $langcode => $language) {
      if ($source->hasTranslation($langcode)) {
        parent::index($source->getTranslation($langcode));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function delete($source) {
    /** @var \Drupal\node\Entity\Node $source */
    foreach ($source->getTranslationLanguages() as $langcode => $language) {
      if ($source->hasTranslation($langcode)) {
        parent::delete($source->getTranslation($langcode));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setup() {
    $languages = $this->languageManager->getLanguages();
    // Add an "undefined" language so that content is indexed properly.
    $languages['und'] = 'Language undefined';
    // Create one index per language, so that we can have different analyzers.
    foreach ($languages as $langcode => $language) {
      if (!$this->client->indices()->exists(['index' => 'event-node-' . $langcode])) {
        $this->client->indices()->create([
          'index' => 'event-node-' . $langcode,
          'body' => [
            // Use a single shard to improve relevance on a small dataset.
            'number_of_shards' => 1,
            // No need for replicas, we only have one ES node.
            'number_of_replicas' => 0,
          ],
        ]);
        $analyzer = ElasticsearchLanguageAnalyzer::get($langcode);
        $mapping = [
          'index' => 'event-node-' . $langcode,
          'type' => 'node',
          'body' => [
            'properties' => [
              'id' => ['type' => 'integer'],
              'uuid' => ['type' => 'keyword'],
              'service_id' => ['type' => 'keyword'],
              'bundle' => [
                'type' => 'keyword',
              ],
              'created' => [
                'type' => 'date',
                'format' => 'epoch_second',
              ],
              'status' => [
                'type' => 'boolean',
              ],
              'title' => [
                'type' => 'text',
                'analyzer' => $analyzer,
              ],
              'content' => [
                'type' => 'text',
                'analyzer' => $analyzer,
                // Trade off index size for better highlighting.
                'term_vector' => 'with_positions_offsets',
              ],
            ],
          ],
        ];
        $this->client->indices()->putMapping($mapping);
      }
    }
  }

}
