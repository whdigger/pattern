<?php

namespace App\Pattern\Structural\Fasad\Component;

// Уточнение пользователя, в качестве пользователя по-умолчанию
class DefaultUser extends User
{
    public function getUserRole()
    {
        return "DEFAULT_USER";
    }
}