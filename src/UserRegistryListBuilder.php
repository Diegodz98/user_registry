<?php

declare(strict_types=1);

namespace Drupal\user_registry;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the user registry entity type.
 */
final class UserRegistryListBuilder extends EntityListBuilder
{


  /**
   * The number of entities to list per page, or FALSE to list all entities.
   *
   * For example, set this to FALSE if the list uses client-side filters that
   * require all entities to be listed (like the views overview).
   *
   * @var int|false
   */
  protected $limit = 10;

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array
  {
    $header['id'] = $this->t('ID');
    $header['full_name'] = $this->t('Full Name');
    $header['email'] = $this->t('Email');
    $header['dni'] = $this->t('DNI');
    $header['birth_date'] = $this->t('Date of Birth');
    $header['created'] = $this->t('Created');
    $header['changed'] = $this->t('Updated');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array
  {
    /** @var \Drupal\user_registry\Contract\UserRegistryInterface $entity */
    $row['id'] = $entity->toLink();
    $row['full_name'] = $entity->get('full_name')->value;
    $row['email'] = $entity->get('email')->value;
    $row['dni'] = $entity->get('dni')->value;
    $row['birth_date'] = $entity->get('birth_date')->value;
    $row['created']['data'] = $entity->get('created')->view(['label' => 'hidden']);
    $row['changed']['data'] = $entity->get('changed')->view(['label' => 'hidden']);
    return $row + parent::buildRow($entity);
  }
}
