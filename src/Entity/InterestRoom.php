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
 *     "view_builder" = "Drupal\interesting\InterestRoomViewBuilder",
 *     "list_builder" = "Drupal\interesting\InterestRoomListBuilder",
 *     "views_data" = "Drupal\interesting\Entity\InterestRoomViewsData",
 *     "storage" = "Drupal\rethinkdb\RethinkStorage",
 *     "form" = {
 *       "default" = "Drupal\interesting\Form\InterestRoomForm",
 *       "add" = "Drupal\interesting\Form\InterestRoomForm",
 *       "edit" = "Drupal\interesting\Form\InterestRoomForm",
 *       "delete" = "Drupal\interesting\Form\InterestRoomDeleteForm",
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
   * Get the address from the lat and lon of the entity.
   *
   * @return string
   *   The formatted address of the geo location.
   */
  public function getAddress() {

    if (!$location = $this->location->getArrayCopy()) {
      return;
    }

    $address = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $location['lat'] . ',' . $location['lon'] . '&sensor=true';
    $content = \Drupal::httpClient()->get($address)->getBody()->getContents();
    return \GuzzleHttp\json_decode($content)->results[0]->formatted_address;
  }

}
