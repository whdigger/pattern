<?php

namespace App\Pattern\Structural\Fasad\Component;

abstract class User
{
    public function __construct(protected string $username, protected string $passwd)
    {
    }

    public abstract function getUserRole();

    public function getPasswdHash()
    {
        return md5($this->passwd);
    }

}