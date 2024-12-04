<?php

declare(strict_types=1);

namespace Drupal\user_registry\Contract;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an user registry entity type.
 */
interface UserRegistryInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {}
