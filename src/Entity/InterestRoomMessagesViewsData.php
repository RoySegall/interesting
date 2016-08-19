<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoomMessages.
 */

namespace Drupal\interesting\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Interest room messages entities.
 */
class InterestRoomMessagesViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['interest_room_messages']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Interest room messages'),
      'help' => $this->t('The Interest room messages ID.'),
    );

    return $data;
  }

}
