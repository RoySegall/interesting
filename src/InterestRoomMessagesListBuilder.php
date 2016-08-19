<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMessagesListBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Interest room messages entities.
 *
 * @ingroup interesting
 */
class InterestRoomMessagesListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Interest room messages ID');
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
    /* @var $entity \Drupal\interesting\Entity\InterestRoomMessages */
    $row['id'] = $entity->id();
    $row['name'] =
      $this->getLabel($entity)
    ;
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultOperations(EntityInterface $entity) {

    $operations = array();
    if ($entity->access('delete') && $entity->hasLinkTemplate('delete-form')) {
      $operations['delete'] = array(
        'title' => $this->t('Delete'),
        'weight' => 20,
        'url' => \Drupal\Core\Url::fromRoute('entity.interest_room_members.delete_form', [
          'interest_room' => $entity->room_id,
          'interest_room_members' => $entity->id(),
        ]),
      );
    }

    return $operations;
  }

}
