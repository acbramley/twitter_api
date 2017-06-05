<?php

namespace Drupal\twitter_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\twitter_api\TwitterApiClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a simple block showing tweets from a user.
 *
 * This is designed to be an example of an API implementation.
 *
 * @Block(
 *   id = "tweets_from_user",
 *   admin_label = @Translation("Tweets from user"),
 *   category = @Translation("Twitter API")
 * )
 */
class TweetsFromUserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The twitter api client service.
   *
   * @var \Drupal\twitter_api\TwitterApiClientInterface
   */
  protected $client;

  /**
   * FacetSearchFormBlock constructor.
   *
   * @param array $configuration
   *   The plugin config.
   * @param string $plugin_id
   *   The plugin id.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\twitter_api\TwitterApiClientInterface $client
   *   The twitter api client service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TwitterApiClientInterface $client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('twitter_api.client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function baseConfigurationDefaults() {
    return [
      'screen_name' => '',
      'count' => 3,
    ] + parent::baseConfigurationDefaults();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['screen_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Username'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['screen_name'],
    ];
    $form['count'] = [
      '#type' => 'number',
      '#title' => $this->t('Count'),
      '#description' => $this->t('Number of tweets to display.'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['count'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['screen_name'] = $form_state->getValue('screen_name');
    $this->configuration['count'] = $form_state->getValue('count');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $response = $this->client->getTweets($this->configuration['screen_name'], $this->configuration['count']);
    $tweets = [];
    foreach ($response as $tweet) {
      $tweets[] = ['#theme' => 'twitter_api__tweet', '#tweet' => $tweet];
    }
    $build = [
      '#theme' => 'twitter_api__tweet_list',
      '#tweets' => $tweets,
    ];

    return $build;
  }

}
