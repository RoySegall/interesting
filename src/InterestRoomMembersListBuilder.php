<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMembersListBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\user\Entity\User;

/**
 * Defines a class to build a listing of Interest room members entities.
 *
 * @ingroup interesting
 */
class InterestRoomMembersListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Interest room members ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function load() {
    // todo - fix rethink DB to just return ids.
    $entity = $this->getEntityIds();
    return $this->storage->loadMultiple(array_keys($entity));
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoomMembers */
    $row['id'] = $entity->id();
    $row['name'] = User::load($entity->user_id)->toLink();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityIds() {
    $query = $this->getStorage()->getQuery()
      ->sort('created')
      ->condition('room_id', \Drupal::routeMatch()->getParameter('interest_room'));

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }

    return $query->execute();
  }

}
