<?php

namespace App\Domain\Model\Security;

use App\Domain\Repository\Exception\ModelRecordNotFoundException;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!($user instanceof User)) {
            throw new UnsupportedUserException();
        }
        $this->userRepository->refresh($user);
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        try {
            return $this->userRepository->findByEmail($username);
        } catch (ModelRecordNotFoundException $e) {
            throw new UserNotFoundException($e);
        }
    }
}