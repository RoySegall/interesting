<?php

/**
 * @file
 * Contains Drupal\interesting\Controller\InterestingRest.
 */

namespace Drupal\interesting\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\simple_oauth\Authentication\Provider\SimpleOauthAuthenticationProvider;
use Drupal\simple_oauth\Entity\AccessToken;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class InterestingRest.
 *
 * @package Drupal\interesting\Controller
 */
class InterestingRest extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $EntityManager;

  /**
   * Simple OAuth object.
   *
   * @var \Drupal\simple_oauth\Authentication\Provider\SimpleOauthAuthenticationProvider
   */
  protected $SimpleOAuth;

  /**
   * The request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManagerInterface $entity_manager, SimpleOauthAuthenticationProvider $simple_oauth) {
    $this->EntityManager = $entity_manager;
    $this->SimpleOAuth = $simple_oauth;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('simple_oauth.authentication.simple_oauth')
    );
  }

  /**
   * Handling rest for user.
   *
   * @param Request $request
   *   The request end object.
   *
   * @return Json
   */
  public function api(Request $request) {
    $this->request = $request;

    switch ($request->getMethod()) {
      case 'POST':
        return $this->post();

      case 'GET':
        return $this->get();
    }
  }

  /**
   * Creating a user.
   *
   * @return JsonResponse
   * @throws \Exception
   */
  protected function post() {
    parse_str($this->request->getContent(), $payload);

    if (!$payload) {
      throw new \Exception('The payload is empty');
    }

    if (empty($payload['name']) || empty($payload['pass']) || empty($payload['mail'])) {
      throw new \Exception('One of the missing values is empty: username, password, mail');
    }

    // Creating the account.
    $account = $this->entityTypeManager()->getStorage('user')->create($payload);
    $account->set('status', TRUE);
    $account->save();

    // Generate the token.
    $this->entityTypeManager->getStorage('access_token')->create([
      'auth_user_id' => $account->id(),
      'user_id' => $account->id(),
    ])->save();

    $result = \Drupal::entityQuery('access_token')
      ->condition('auth_user_id', 6)
      ->condition('resource', 'authentication')
      ->execute();

    $token = AccessToken::load(reset($result));

    $access_token = AccessToken::load($token->get('access_token_id')->target_id);

    return new JsonResponse([
      'refresh_token' => $token->get('value')->value,
      'access_token' => $access_token->get('value')->value,
      'expires' => $token->get('expire')->value,
    ]);
  }

  /**
   * Getting a user with using an access token.
   *
   * @return JsonResponse
   * @throws \Exception
   */
  protected function get() {
    if (!$auth = $this->SimpleOAuth->authenticate($this->request)) {
      throw new \Exception('Could not find a user with that access token.');
    }

    return new JsonResponse(['id' => $auth->id(), 'name' => $auth->label()]);
  }

}
