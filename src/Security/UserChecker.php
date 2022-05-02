<?php

namespace App\Security;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class UserChecker implements UserCheckerInterface
{

    /**
     * @param UserInterface $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
        if (!$user->isEnable()) {
            throw new EnabledUserException();
        }
    }

    /**
     * @param UserInterface $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {
    }
}