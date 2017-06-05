<?php

namespace Drupal\Tests\twitter_api\Kernel;

use Drupal\Tests\token\Kernel\KernelTestBase;

/**
 * Kernel tests for the twitter API clent.
 */
class TwitterApiClientTest extends KernelTestBase {

  /**
   * Our client to test.
   *
   * @var \Drupal\twitter_api\TwitterApiClientInterface
   */
  protected $client;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'twitter_api',
    'twitter_api_test',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->installConfig('twitter_api_test');
    $this->client = \Drupal::service('twitter_api.client');
  }

  /**
   * Tests the get tweets function.
   */
  public function testGetTweets() {
    $tweets = $this->client->getTweets('drupaltestacc', 1);
    $this->assertNotEmpty($tweets);
    $this->assertContains('This is a test tweet', $tweets[0]['text']);
  }

}
