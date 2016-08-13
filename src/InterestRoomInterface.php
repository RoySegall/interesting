<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomInterface.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Interest room entities.
 *
 * @ingroup interesting
 */
interface InterestRoomInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

}
