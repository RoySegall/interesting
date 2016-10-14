<?php

/**
 * @file
 * Contains Drupal\interesting\Form\InterestRoomMessagesForm.
 */

namespace Drupal\interesting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;
use Drupal\interesting\Entity\InterestRoom;
use Drupal\user\Entity\User;

/**
 * Form controller for Interest room messages edit forms.
 *
 * @ingroup interesting
 */
class InterestRoomMessagesForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoomMessages */
    $form = parent::buildForm($form, $form_state);

    $form['message'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Text'),
    ];

    $form['user_id'] = [
      '#title' => $this->t('Username'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#required' => TRUE,
      '#default_value' => User::load(\Drupal::currentUser()->getAccount()->id()),
    ];

    return $form;
  }

  /**
   * Get the room object from the route object.
   *
   * @return InterestRoom
   */
  protected function getRoom() {
    $id = \Drupal::routeMatch()->getParameter('interest_room');
    return InterestRoom::load($id);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->buildEntity($form, $form_state);

    // The entity was validated.
    $entity->setValidationRequired(FALSE);
    $form_state->setTemporaryValue('entity_validated', TRUE);

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $entity->user_id = $values['user_id'];
    $entity->room_id = $this->getRoom()->id();
    $entity->created = time();
    $entity->text = $values['message']['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();

    $form_state->setRedirect('entity.interest_room_messages.collection', [
      'interest_room' => $this->entity->room_id,
    ]);
  }

}
