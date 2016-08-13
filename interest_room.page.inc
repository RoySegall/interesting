<?php

/**
 * @file
 * Contains interest_room.page.inc.
 *
 * Page callback for Interest room entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Interest room templates.
 *
 * Default template: interest_room.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_interest_room(array &$variables) {
  // Fetch InterestRoom Entity Object.
  $interest_room = $variables['elements']['#interest_room'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
