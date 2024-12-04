<?php

declare(strict_types=1);

namespace Drupal\user_registry;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user_registry\Contract\UserRegistryStorageInterface;

/**
 * @todo Add class description.
 */
final class UserRegistryStorage implements UserRegistryStorageInterface
{

    /**
   * The entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $entityStorage;
  /**
   * Constructs an UserRegistryStorage object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityStorage = $entity_type_manager->getStorage('user_registry');
  }

  /**
   * {@inheritdoc}
   */
  public function loadByDni(string $dni): ?EntityInterface
  {
    // Query for the entity by DNI
    $query = $this->entityStorage->getQuery()
      ->condition('dni', $dni)
      ->accessCheck(TRUE)
      ->range(0, 1)
      ->execute();

    // Return the entity if found, otherwise NULL
    if (!empty($query)) {
      return $this->entityStorage->load(reset($query));
    }

    return NULL;
  }
}
