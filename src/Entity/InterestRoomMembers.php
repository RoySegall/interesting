<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoomMembers.
 */

namespace Drupal\interesting\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\rethinkdb\Entity\AbstractRethinkDbEntity;
use Drupal\user\UserInterface;

/**
 * Defines the Interest room members entity.
 *
 * @ingroup interesting
 *
 * @ContentEntityType(
 *   id = "interest_room_members",
 *   label = @Translation("Interest room members"),
 *   handlers = {
 *     "list_builder" = "Drupal\interesting\InterestRoomMembersListBuilder",
 *     "storage" = "Drupal\rethinkdb\RethinkStorage",
 *     "form" = {
 *       "default" = "Drupal\interesting\Form\InterestRoomMembersForm",
 *       "add" = "Drupal\interesting\Form\InterestRoomMembersForm",
 *       "edit" = "Drupal\interesting\Form\InterestRoomMembersForm",
 *       "delete" = "Drupal\interesting\Form\InterestRoomMembersDeleteForm",
 *     },
 *     "access" = "Drupal\interesting\InterestRoomMembersAccessControlHandler",
 *   },
 *   base_table = "interest_room_members",
 *   admin_permission = "administer InterestRoomMembers entity",
 *   entity_keys = {
 *   },
 *   links = {
 *     "canonical" = "/admin/content/interest_room/{interest_room}/members",
 *     "delete-form" = "/admin/content/interest_room_members/{interest_room_members}/delete"
 *   }
 * )
 */
class InterestRoomMembers extends AbstractRethinkDbEntity {

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
