<?php

declare(strict_types=1);

namespace Drupal\user_registry\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the user registry entity edit forms.
 */
final class UserRegistryForm extends ContentEntityForm
{

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int
  {
    $result = parent::save($form, $form_state);

    $message_args = ['%label' => $this->entity->toLink()->toString()];
    $logger_args = [
      '%label' => $this->entity->label(),
      'link' => $this->entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New user registry %label has been created.', $message_args));
        $this->logger('user_registry')->notice('New user registry %label has been created.', $logger_args);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The user registry %label has been updated.', $message_args));
        $this->logger('user_registry')->notice('The user registry %label has been updated.', $logger_args);
        break;

      default:
        throw new \LogicException('Could not save the entity.');
    }

    $form_state->setRedirectUrl($this->entity->toUrl());

    return $result;
  }

  /**
   * {@inheritdoc}
   *
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    parent::validateForm($form, $form_state);

    // Retrieve the DNI value from the form
    $dni = $form_state->getValue('dni')[0]['value'];

    // Validate that the DNI contains only numbers
    if (!preg_match('/^\d+$/', $dni)) {
      // If the DNI is not numeric, add an error to the form
      $form_state->setErrorByName('dni', t('The DNI must contain only numbers.'));
    }
  }
}
