<?php

namespace Drupal\Tests\twitter_api\Kernel;

use Drupal\Tests\token\Kernel\KernelTestBase;

/**
 * Unit tests for the entity expander.
 */
class TwitterApiEntityExpanderTest extends KernelTestBase {

  /**
   * The expander service.
   *
   * @var \Drupal\twitter_api\TwitterApiEntityExpander
   */
  protected $expander;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'twitter_api',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->expander = \Drupal::service('twitter_api.entity_expander');
  }

  /**
   * Tests the expand urls function.
   */
  public function testExpandUrls() {
    // Example structure of a tweet with a url entity.
    $tweet = [
      'entities' => [
        'urls' => [
          [
            'url' => 'https://t.co/Vfe5BIiYt5',
            'expanded_url' => 'https://twitter.com',
            'display_url' => 'twitter.com',
            'indicies' => [
              21,
              44,
            ],
          ],
        ],
      ],
    ];

    $actual = $this->expander->expandUrls($tweet);
    $this->assertEquals('<a href="https://twitter.com">twitter.com</a>', $actual['https://t.co/Vfe5BIiYt5']->toString());
  }

}
