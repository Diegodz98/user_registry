<?php

declare(strict_types=1);

namespace Drupal\user_registry\Contract;

use Drupal\Core\Entity\EntityInterface;

/**
 * Defines the interface for the user registry storage service.
 */
interface UserRegistryStorageInterface
{

  /**
   * Loads a user registry entity by DNI.
   *
   * @param string $dni
   *   The DNI to search for.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   The user registry entity, or NULL if not found.
   */
  public function loadByDni(string $dni): ?EntityInterface;
}
