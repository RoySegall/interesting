<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomAccessControlHandler.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Interest room entity.
 *
 * @see \Drupal\interesting\Entity\InterestRoom.
 */
class InterestRoomAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view interest room entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit interest room entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete interest room entities');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add interest room entities');
  }

}
