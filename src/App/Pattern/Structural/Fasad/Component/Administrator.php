<?php

namespace App\Pattern\Structural\Fasad\Component;

// Уточнение пользователя, в качестве администратора
class Administrator extends User
{
    public function getUserRole()
    {
        return "ADMINISTRATOR";
    }
}