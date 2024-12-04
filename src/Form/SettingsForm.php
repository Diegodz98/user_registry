<?php

declare(strict_types=1);

namespace Drupal\user_registry\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure User Registry* settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

 
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'user_registry.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_registry_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('user_registry.settings');

    // Label for full name field.
    $form['full_name_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name Label'),
      '#default_value' => $config->get('full_name_label') ?? $this->t('Full Name'),
      '#description' => $this->t('The label for the full name field in the registration form.'),
    ];

    // Label for email field.
    $form['email_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email Label'),
      '#default_value' => $config->get('email_label') ?? $this->t('Email'),
      '#description' => $this->t('The label for the email field in the registration form.'),
    ];

    // Label for DNI field.
    $form['dni_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('DNI Label'),
      '#default_value' => $config->get('dni_label') ?? $this->t('DNI'),
      '#description' => $this->t('The label for the DNI field in the registration form.'),
    ];

    // Label for birth date field.
    $form['birth_date_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date of Birth Label'),
      '#default_value' => $config->get('birth_date_label') ?? $this->t('Date of Birth'),
      '#description' => $this->t('The label for the date of birth field in the registration form.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save the configuration values.
    $this->config('user_registry.settings')
      ->set('full_name_label', $form_state->getValue('full_name_label'))
      ->set('email_label', $form_state->getValue('email_label'))
      ->set('dni_label', $form_state->getValue('dni_label'))
      ->set('birth_date_label', $form_state->getValue('birth_date_label'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}