<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoomMessages.
 */

namespace Drupal\interesting\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\rethinkdb\Entity\AbstractRethinkDbEntity;
use Drupal\user\UserInterface;

/**
 * Defines the Interest room messages entity.
 *
 * @ingroup interesting
 *
 * @ContentEntityType(
 *   id = "interest_room_messages",
 *   label = @Translation("Interest room messages"),
 *   handlers = {
 *     "list_builder" = "Drupal\interesting\InterestRoomMessagesListBuilder",
 *     "storage" = "Drupal\rethinkdb\RethinkStorage",
 *     "form" = {
 *       "default" = "Drupal\interesting\Form\InterestRoomMessagesForm",
 *       "add" = "Drupal\interesting\Form\InterestRoomMessagesForm",
 *       "delete" = "Drupal\interesting\Form\InterestRoomMessagesDeleteForm",
 *     },
 *     "access" = "Drupal\interesting\InterestRoomMessagesAccessControlHandler",
 *   },
 *   base_table = "interest_room_messages",
 *   admin_permission = "administer InterestRoomMessages entity",
 *   entity_keys = {},
 *   links = {
 *     "canonical" = "/admin/content/interest_room/{interest_room}/messages",
 *     "delete-form" = "/admin/content/interest_room_messages/{interest_room_messages}/delete"
 *   }
 * )
 */
class InterestRoomMessages extends AbstractRethinkDbEntity {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * Get the owner of the entity.
   *
   * @return UserInterface
   */
  public function getOwner() {
    return $this->entityTypeManager()->getStorage('user')->load($this->user_id);
  }

}
