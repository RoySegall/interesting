<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMembersListBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;
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
  protected function getDefaultOperations(EntityInterface $entity) {

    $operations = array();
    if ($entity->access('delete') && $entity->hasLinkTemplate('delete-form')) {
      $operations['delete'] = array(
        'title' => $this->t('Delete'),
        'weight' => 100,
        'url' => \Drupal\Core\Url::fromRoute('entity.interest_room_members.delete_form', [
          'interest_room' => $entity->room_id,
          'interest_room_members' => $entity->id(),
        ]),
      );
    }

    return $operations;
  }

}
