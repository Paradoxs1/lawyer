<?php

namespace App\Exception;


use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserEnableException extends AuthenticationException
{

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'Your account is not activated.';
    }
}
