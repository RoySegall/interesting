<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoomMembers.
 */

namespace Drupal\interesting\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\rethinkdb\Entity\AbstractRethinkDbEntity;

/**
 * Defines the Interest room members entity.
 *
 * @ingroup interesting
 *
 * @ContentEntityType(
 *   id = "interest_room_members",
 *   label = @Translation("Interest room members"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\interesting\InterestRoomMembersListBuilder",
 *     "views_data" = "Drupal\interesting\Entity\InterestRoomMembersViewsData",
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
 *     "edit-form" = "/admin/content/interest_room/{interest_room}/members/{interest_room_members}/edit",
 *     "delete-form" = "/admin/content/interest_room/{interest_room}/members/{interest_room_members}/delete"
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

}
