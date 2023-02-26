<?php

namespace App\Pattern\Creational\MethodFactory\Product;

class FacebookConnector implements SocialNetworkConnector
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
        printf(self::MSG_POST, 'Facebook') ;
    }

    public function logout()
    {
        printf(self::MSG_LOGOUT, $this->login) ;
    }
}