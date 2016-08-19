<?php

/**
 * @file
 * Contains Drupal\interesting\Entity\InterestRoomMembers.
 */

namespace Drupal\interesting\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Interest room members entities.
 */
class InterestRoomMembersViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['interest_room_members']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Interest room members'),
      'help' => $this->t('The Interest room members ID.'),
    );

    return $data;
  }

}
