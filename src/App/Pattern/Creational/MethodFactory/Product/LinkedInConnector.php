<?php

namespace App\Pattern\Creational\MethodFactory\Product;

class LinkedInConnector implements SocialNetworkConnector
{
    public function __construct(public string $login, public string $password)
    {
    }

    public function logIn()
    {
        printf(self::MSG_LOGIN, $this->login, $this->password) ;
    }

    public function createPost($content)
    {
        printf(self::MSG_POST, 'LinkedIn') ;
    }

    public function logout()
    {
        printf(self::MSG_LOGOUT, $this->login) ;
    }
}