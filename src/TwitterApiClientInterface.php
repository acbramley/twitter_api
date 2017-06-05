<?php

namespace Drupal\twitter_api;

/**
 * Interface TwitterApiClientInterface.
 */
interface TwitterApiClientInterface {

  /**
   * Gets the latest tweets for a given user.
   *
   * @param string $screen_name
   *   The Twitter account name.
   * @param int $count
   *   The number of tweets to return.
   *
   * @return array
   *   The decoded response.
   */
  public function getTweets($screen_name, $count = 3);

  /**
   * Send a GET query to a specific endpoint with an optional array of params.
   *
   * @param string $end_point
   *   The url endpoint e.g statuses/user_timeline.json.
   * @param array $query_params
   *   An optional array of query parameters.
   *
   * @return array
   *   The decoded JSON response.
   */
  public function doGet($end_point, array $query_params);

}
