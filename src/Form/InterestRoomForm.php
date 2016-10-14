<?php

/**
 * @file
 * Contains Drupal\interesting\Form\InterestRoomForm.
 */

namespace Drupal\interesting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Form controller for Interest room edit forms.
 *
 * @ingroup interesting
 */
class InterestRoomForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\interesting\Entity\InterestRoom */
    $entity = $this->entity;

    $location = ['lat' => '', 'lon' => ''];
    if (!empty($entity->values['location'])) {
      $location = $entity->values['location']->getArrayCopy();
    }

    $form = [
      'name' => [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#required' => TRUE,
        '#default_value' => !empty($entity->values['name']) ? $entity->values['name'] : '',
      ],
      'range' => [
        '#type' => 'textfield',
        '#title' => $this->t('Range'),
        '#description' => $this->t('Define the range in which the room will be available. Format: 0.5KM, 100M'),
        '#required' => TRUE,
        '#default_value' => !empty($entity->values['range']) ? $entity->values['range'] : '',
      ],
      'find_address' => [
        '#type' => 'checkbox',
        '#title' => t('Find geolocation from address'),
      ],
      'address' => [
        '#type' => 'fieldset',
        '#title' => $this->t('Search address geolocation'),
        'location' => [
          '#type' => 'textfield',
          '#title' => $this->t('Title'),
        ],
        'search' => [
          '#type' => 'button',
          '#value' => $this->t('Search'),
        ],
        '#states' => [
          'visible' => [
            ':input[name="find_address"]' => ['checked' => TRUE],
          ],
        ],
      ],
      'location' => [
        '#type' => 'geofield_latlon',
        '#required' => TRUE,
        '#title' => $this->t('Geo location'),
        '#default_value' => $location,
        '#geolocation' => 1,
      ],
      'actions' => [
        '#type' => 'actions',
        'submit' => [
          '#type' => 'submit',
          '#value' => $this->t('Send'),
        ],
      ],
      '#attached' => [
        'library' => ['interesting/interesting.geolocation'],
      ],
    ];

    // Adding the address information.
    if ($location['lat'] && $location['lon']) {
      $params = [
        '@address' => $entity->getAddress(),
      ];

      $form['location']['#suffix'] = $this->t('Suggested formatted address: @address', $params);
    }

    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Status'),
      '#description' => $this->t('Determine if the room is on or not'),
      '#default_value' => isset($entity->values['status']) ? $entity->values['status'] : TRUE,
    ];

    $form['user_id'] = [
      '#title' => $this->t('Username'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#required' => TRUE,
      '#default_value' => User::load($entity->values['user_id']),
    ];

    $this->actions($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $entity->name = $values['name'];
    $entity->range = $values['range'];
    $entity->location = [
      'lat' => $values['location']['lat'],
      'lon' => $values['location']['lon'],
    ];
    $entity->status = $values['status'];
    $entity->user_id = $values['user_id'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->buildEntity($form, $form_state);

    // No need to validate for now.
//    $entity->validate();

    // The entity was validated.
    $entity->setValidationRequired(FALSE);
    $form_state->setTemporaryValue('entity_validated', TRUE);

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->entity->save();
    $form_state->setRedirect('entity.interest_room.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity->save();
    $form_state->setRedirect('entity.interest_room.edit_form', ['interest_room' => $entity->id()]);
  }

}
