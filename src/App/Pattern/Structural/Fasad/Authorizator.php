<?php

namespace App\Pattern\Structural\Fasad;

/*
Проблема: Минимизировать зависимость подсистем некоторой сложной системы и обмен информацией между ними.
Решение: Отдельные компоненты системы могу быть разработаны изолированно, затем интегрированы вместе.
Некоторый объект, аккумулирующий в себе высокоуровневый набор операций для работы с некоторой сложной подсистемой
Фасад - авторизатор пользователей
*/

use App\Pattern\Structural\Fasad\Component\SQLiteDB;

class Authorizator
{
    // Авторизация пользователя
    public function authorizate(string $username, string $passwd)
    {
        $db = new SQLiteDB("db.sqlite");
        $user = $db->search($username);
        if ($user->getPasswdHash() != $passwd) {
            throw new \Exception("Wrong password or username!");
        }
    }
}