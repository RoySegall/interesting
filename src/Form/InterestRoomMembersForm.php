<?php

/**
 * @file
 * Contains Drupal\interesting\Form\InterestRoomMembersForm.
 */

namespace Drupal\interesting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;
use Drupal\interesting\Entity\InterestRoom;

/**
 * Form controller for Interest room members edit forms.
 *
 * @ingroup interesting
 */
class InterestRoomMembersForm extends ContentEntityForm {

  /**
   * Get the room object from the route object.
   *
   * @return InterestRoom
   */
  protected function getRoom() {
    $id = \Drupal::routeMatch()->getParameter('interest_room');
    return InterestRoom::load($id);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoomMembers */
    $form = parent::buildForm($form, $form_state);

    $form['user_id'] = [
      '#title' => $this->t('Username'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $entity->user_id = $values['user_id'];
    $entity->room_id = $this->getRoom()->id();
    $entity->created = time();
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->buildEntity($form, $form_state);

    if ($this->getRoom()->values['user_id'] == $form_state->getValue('user_id')) {
      $form_state->setErrorByName('user_id', $this->t('You cannot add the owner of the room.'));
    }
    else {
      // Check if the user is already in the room.
      $result = \Drupal::entityQuery('interest_room_members')
        ->condition('room_id', $this->getRoom()->id())
        ->execute();

      if ($result) {
        $form_state->setErrorByName('user_id', $this->t('The user is already in this room.'));
      }
    }

    $entity->validate();

    // The entity was validated.
    $entity->setValidationRequired(FALSE);
    $form_state->setTemporaryValue('entity_validated', TRUE);

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();
    $form_state->setRedirect('entity.interest_room_members.collection', ['interest_room' => $this->entity->room_id]);
  }

}
