<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMembersAccessControlHandler.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Interest room members entity.
 *
 * @see \Drupal\interesting\Entity\InterestRoomMembers.
 */
class InterestRoomMembersAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view interest room members entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit interest room members entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete interest room members entities');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add interest room members entities');
  }

}
