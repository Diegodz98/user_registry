<?php

declare(strict_types=1);

namespace Drupal\user_registry\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;
use Drupal\user_registry\Contract\UserRegistryInterface;

/**
 * Defines the user registry entity class.
 *
 * @ContentEntityType(
 *   id = "user_registry",
 *   label = @Translation("User registry"),
 *   label_collection = @Translation("User registries"),
 *   label_singular = @Translation("user registry"),
 *   label_plural = @Translation("user registries"),
 *   label_count = @PluralTranslation(
 *     singular = "@count user registries",
 *     plural = "@count user registries",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\user_registry\UserRegistryListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\user_registry\UserRegistryAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\user_registry\Form\UserRegistryForm",
 *       "edit" = "Drupal\user_registry\Form\UserRegistryForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "user_registry",
 *   admin_permission = "administer user_registry",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/registry/users",
 *     "add-form" = "/admin/registry/users/add",
 *     "canonical" = "/admin/registry/users/{user_registry}",
 *     "edit-form" = "/admin/registry/users/{user_registry}/edit",
 *     "delete-form" = "/admin/registry/users/{user_registry}/delete",
 *     "delete-multiple-form" = "/admin/registry/users/delete-multiple",
 *   },
 * )
 */
final class UserRegistry extends ContentEntityBase implements UserRegistryInterface
{

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void
  {
    parent::preSave($storage);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array
  {
    $labels_config = \Drupal::config('user_registry.settings');

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Advertiser entity.'))
      ->setReadOnly(TRUE);
    // Campo Nombrecompleto.
    $fields['full_name'] = BaseFieldDefinition::create('string')
      ->setLabel($labels_config->get('full_name_label') ?? t('Full Name'))
      ->setDescription(t('The full name of the user.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Campo Correo electrónico.
    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel($labels_config->get('email_label') ?? t('Email'))
      ->setDescription(t('The email address of the user.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'email_default',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'email_mailto',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Campo DNI.
    $fields['dni'] = BaseFieldDefinition::create('string')
      ->setLabel($labels_config->get('dni_label') ?? t('DNI'))
      ->setDescription(t('The national identification number of the user.'))
      ->setSettings([
        'max_length' => 20,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE)
      ->addConstraint('UniqueField') // Restringe la unicidad del campo.
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 30,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 30,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Campo Fechadenacimiento.
    $fields['birth_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel($labels_config->get('birth_date') ?? t('Date of Birth'))
      ->setDescription(t('The date of birth of the user.'))
      ->setSettings([
        'datetime_type' => 'date',
      ])
      ->setRequired(FALSE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 40,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'weight' => 40,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the user registry was created.'));


    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the user registry was last edited.'));

    return $fields;
  }
}
