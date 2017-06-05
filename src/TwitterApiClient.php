<?php

namespace Drupal\twitter_api;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class TwitterApiClient.
 *
 * Drupal wrapper for TwitterAPIExchange.
 */
class TwitterApiClient implements TwitterApiClientInterface {

  /**
   * This module's configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * TwitterApiClient constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('twitter_api.settings');
  }

  /**
   * Gets an array of settings for passing to the exchange.
   *
   * @return array
   *   An array of settings.
   */
  protected function getClientSettings() {
    return [
      'oauth_access_token' => $this->config->get('oauth_access_token'),
      'oauth_access_token_secret' => $this->config->get('oauth_access_token_secret'),
      'consumer_key' => $this->config->get('consumer_key'),
      'consumer_secret' => $this->config->get('consumer_secret'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function doGet($end_point, array $query_params) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getTweets($screen_name, $count = 3) {
    $params = [
      'screen_name' => $screen_name,
      'count' => $count,
    ];
    return $this->doGet('statuses/user_timeline.json', $params);
  }

}
