<?php

namespace App\Security;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class UserChecker implements UserCheckerInterface
{
    /**
     * @inheritDoc
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
        if (!$user->isEnable()) {
            throw new EnabledUserException();
        }
        // TODO: Implement checkPreAuth() method.
    }
    /**
     * @inheritDoc
     */
    public function checkPostAuth(UserInterface $user): void
    {
    }
}