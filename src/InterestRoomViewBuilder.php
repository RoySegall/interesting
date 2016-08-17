<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomViewBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\user\Entity\User;

class InterestRoomViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'full', $langcode = NULL) {
    $data = [];
    $data[] = $this->t('<b>Id:</b> @id', ['@id' => $entity->id()]);
    $data[] = $this->t('<b>Name:</b> @name', ['@name' => $entity->name]);
    $data[] = $this->t('<b>Range:</b> @range', ['@range' => $entity->range]);
    $data[] = $this->t('<b>Status:</b> @status', ['@status' => $entity->status ? $this->t('Available') : $this->t('Hidden/Closed')]);
    $data[] = $this->t('<b>Owner:</b> @owner', ['@owner' => User::load($entity->user_id)->label()]);

    $location = $entity->location->getArrayCopy();

    $data[] = $this->t('<b>Location:</b> @location(@lat, @lan)', ['@location' => $entity->getAddress(), '@lat' => $location['lat'], '@lan' => $location['lon']]);

    return ['#markup' => implode("<br />", $data)];
  }

}
