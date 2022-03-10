<?php

namespace App\Domain\Model\Security;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

class UserResolver
{
    public function __construct(
        private UserProviderInterface $provider,
        private UserPasswordHasherInterface $hasher
    ) {}

    public function onUserResolve(UserResolveEvent $event)
    {
        if ($event->getGrant() != 'password') return;
        try {
            $user = $this->provider->loadUserByUsername($event->getUsername());
            if ($this->hasher->isPasswordValid($user, $event->getPassword())) {
                $event->setUser($user);
            }
        } catch (\Exception) {
        }
    }

    public function onGoogleUserResolve(UserResolveEvent $event)
    {

    }
}