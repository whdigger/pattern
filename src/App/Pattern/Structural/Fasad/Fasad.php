<?php

namespace Facade;

/*
Проблема: Минимизировать зависимость подсистем некоторой сложной системы и обмен информацией между ними.
Решение: Отдельные компоненты системы могу быть разработаны изолированно, затем интегрированы вместе.
Некоторый объект, аккумулирующий в себе высокоуровневый набор операций для работы с некоторой сложной подсистемой
*/

abstract class User {

  protected $username;

  protected $passwd;

  public function __construct(string $username, string $passwd) {
    $this->username = $username;
    $this->passwd = $passwd;
  }

  public abstract function getUserRole();

  public function getPasswdHash() {
    return md5($this->passwd);
  }

}

// Уточнение пользователя, в качестве пользователя по-умолчанию
class DefaultUser extends User {

  public function getUserRole() {
    return "DEFAULT_USER";
  }

}

// Уточнение пользователя, в качестве администратора
class Administrator extends User {

  public function getUserRole() {
    return "ADMINISTRATOR";
  }

}

interface DB {

  public function search(string $username);

}

// Реализация интерфейса БД для SQLite
class SQLiteDB implements DB {

  public function __construct(string $filename) {
  }

  public function search(string $username) {
    return new DefaultUser($username, "qwerty");
  }

}

// Фасад - авторизатор пользователей
class Authorizator {

  // Авторизация пользователя
  public function authorizate(string $username, string $passwd) {
    $db = new SQLiteDB("db.sqlite");
    $user = $db->search($username);
    if ($user->getPasswdHash() == $passwd) {
      // все хорошо, пользователь опознан
    }
    else {
      // что-то пошло не так
      throw new \Exception("Wrong password or username!");
    }
  }

}

// Вымышленный пользователь
$username = "Vasya";
$passwd = "qwerty";

$auth = new Authorizator();
$auth->authorizate($username, $passwd);