<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomListBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Interest room entities.
 *
 * @ingroup interesting
 */
class InterestRoomListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Interest room ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoom */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $this->getLabel($entity),
      new Url(
        'entity.interest_room.edit_form', array(
          'interest_room' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
