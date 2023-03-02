<?php

namespace App\Pattern\Structural\Fasad\Component;

// Реализация интерфейса БД для SQLite
class SQLiteDB implements DB
{
    public function __construct(string $filename)
    {
    }

    public function search(string $username)
    {
        return new DefaultUser($username, "qwerty");
    }
}