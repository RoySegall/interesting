<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoom.
 */

namespace Drupal\interesting\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\interesting\InterestRoomInterface;
use Drupal\rethinkdb\Entity\AbstractRethinkDbEntity;
use Drupal\rethinkdb_websocket\Controller\RethinkDBMessage;
use Drupal\user\UserInterface;

/**
 * Defines the Interest room entity.
 *
 * @ingroup interesting
 *
 * @ContentEntityType(
 *   id = "interest_room",
 *   label = @Translation("Interest room"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\interesting\InterestRoomListBuilder",
 *     "views_data" = "Drupal\interesting\Entity\InterestRoomViewsData",
 *     "storage" = "Drupal\rethinkdb\RethinkStorage",
 *     "form" = {
 *       "default" = "Drupal\interesting\Entity\Form\InterestRoomForm",
 *       "add" = "Drupal\interesting\Entity\Form\InterestRoomForm",
 *       "edit" = "Drupal\interesting\Entity\Form\InterestRoomForm",
 *       "delete" = "Drupal\interesting\Entity\Form\InterestRoomDeleteForm",
 *     },
 *     "access" = "Drupal\interesting\InterestRoomAccessControlHandler",
 *   },
 *   base_table = "interest_room",
 *   admin_permission = "administer InterestRoom entity",
 *   entity_keys = {},
 *   links = {
 *     "canonical" = "/admin/content/interest_room/{interest_room}",
 *     "edit-form" = "/admin/content/interest_room/{interest_room}/edit",
 *     "delete-form" = "/admin/content/interest_room/{interest_room}/delete"
 *   }
 * )
 */
class InterestRoom extends AbstractRethinkDbEntity {

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
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

}
