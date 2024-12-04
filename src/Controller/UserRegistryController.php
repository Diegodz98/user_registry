<?php

namespace Drupal\user_registry\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\user_registry\Contract\UserRegistryStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the user registry API.
 */
class UserRegistryController extends ControllerBase
{

  /**
   * The user registry storage service.
   *
   * @var \Drupal\user_registry\Contract\UserRegistryStorageInterface
   */
  protected $userRegistryStorage;

  /**
   * Constructs a UserRegistryController object.
   *
   * @param \Drupal\user_registry\Contract\UserRegistryStorageInterface $user_registry_storage
   *   The user registry storage service.
   */
  public function __construct(UserRegistryStorageInterface $user_registry_storage)
  {
    $this->userRegistryStorage = $user_registry_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface
  $container)
  {
    return new static(
      $container->get('user_registry.storage')
    );
  }

  /**
   * Returns user data by DNI.
   *
   * @param string $dni
   *   The DNI to search for.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The JSON response.
   */
  public function getUserByDni(string $dni)
  {
    // Validate DNI (ensure it's numeric and has the correct format).
    if (!preg_match('/^\d+$/', $dni)) {
      return new JsonResponse(['error' => 'Invalid DNI format.'], 400);
    }

    // Query the user by DNI.
    $user = $this->userRegistryStorage->loadByDni($dni);

    if ($user) {
      // Return user data in JSON format.
      return new JsonResponse([
        'full_name' => $user->get('full_name')->value,
        'email' => $user->get('email')->value,
        'dni' => $user->get('dni')->value,
        'birth_date' => $user->get('birth_date')->value,
        'created' => $user->get('created')->value,
        'changed' => $user->get('changed')->value,
      ]);
    } else {
      // Return error if user not found.
      return new JsonResponse(['error' => 'User not found.'], 404);
    }
  }
}
