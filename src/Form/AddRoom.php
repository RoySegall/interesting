<?php

/**
 * @file
 * Contains \Drupal\interesting\Form\ContributeForm.
 */

namespace Drupal\interesting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contribute form.
 */
class AddRoom extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'interesting_add_room';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return [
      'name' => [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#required' => TRUE,
      ],
      'range' => [
        '#type' => 'textfield',
        '#title' => $this->t('Range'),
        '#description' => $this->t('Define the range in which the room will be available. Format: 0.5KM, 100M'),
        '#required' => TRUE,
      ],
      'find_address' => [
        '#type' => 'checkbox',
        '#title' => t('Find geolocation from address'),
      ],
      'address' => [
        '#type' => 'fieldset',
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
        '#default_value' => '',
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
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    dpm($form_state->getValues());
  }

}
