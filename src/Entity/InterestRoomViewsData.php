<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoom.
 */

namespace Drupal\interesting\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Interest room entities.
 */
class InterestRoomViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['interest_room']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Interest room'),
      'help' => $this->t('The Interest room ID.'),
    );

    return $data;
  }

}
