<?php

namespace App\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
class EnabledUserException extends AuthenticationException
{
    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return "Your account isn't enabled.";
    }
}