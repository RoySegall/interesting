<?php

/**
 * @file
 * Contains Drupal\interesting\InterestRoomMembersInterface.
 */

namespace Drupal\interesting;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Interest room members entities.
 *
 * @ingroup interesting
 */
interface InterestRoomMembersInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

}
