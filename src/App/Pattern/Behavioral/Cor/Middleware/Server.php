<?php

namespace App\Pattern\Behavioral\Cor\Middleware;

/**
 * Это класс приложения, который осуществляет реальную обработку запроса. Класс
 * Сервер использует паттерн CoR для выполнения набора различных промежуточных
 * проверок перед запуском некоторой бизнес-логики, связанной с запросом.
 */
class Server
{
    private $users = [];

    /**
     * @var Middleware
     */
    private $middleware;

    /**
     * Клиент может настроить сервер с помощью цепочки объектов middleware.
     */
    public function setMiddleware(Middleware $middleware): void
    {
        $this->middleware = $middleware;
    }

    /**
     * Сервер получает email и пароль от клиента и отправляет запрос авторизации
     * в middleware.
     */
    public function logIn(string $email, string $password): bool
    {
        if ($this->middleware->check($email, $password)) {
            echo "Server: Authorization has been successful!\n";

            // Выполняем что-нибудь полезное для авторизованных пользователей.

            return true;
        }

        return false;
    }

    public function register(string $email, string $password): void
    {
        $this->users[$email] = $password;
    }

    public function hasEmail(string $email): bool
    {
        return isset($this->users[$email]);
    }

    public function isValidPassword(string $email, string $password): bool
    {
        return $this->users[$email] === $password;
    }
}