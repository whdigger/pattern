<?php

namespace App\Pattern\Creational\MethodFactory\Product;

interface SocialNetworkConnector
{
    public const MSG_LOGIN = "Send HTTP API request to log in user %s with password %s\n";
    public const MSG_LOGOUT = "Send HTTP API request to log out user %s\n";
    public const MSG_POST = "Send HTTP API requests to create a post in %s timeline.\n";

    public function logIn();

    public function createPost($content);

    public function logout();
}