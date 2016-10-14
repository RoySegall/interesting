<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMessagesListBuilder.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;

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
    $header['text'] = $this->t('Text');
    $header['created_at'] = $this->t('Created at');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoomMessages */
    $row['id'] = $entity->id();
    $row['name'] = $entity->getOwner()->toLink();
    $row['text'] = ['data' => ['#markup' => $entity->text]];
    $row['created_at'] = \Drupal::service('date.formatter')->format($entity->created);
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
