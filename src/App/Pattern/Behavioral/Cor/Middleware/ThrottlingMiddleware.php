<?php

namespace App\Pattern\Behavioral\Cor\Middleware;

/**
 * Это Конкретное Middleware проверяет, не было ли превышено максимальное число
 * неудачных запросов авторизации.
 */
class ThrottlingMiddleware extends Middleware
{
    private $requestPerMinute;

    private $request;

    private $currentTime;

    public function __construct(int $requestPerMinute)
    {
        $this->requestPerMinute = $requestPerMinute;
        $this->currentTime = time();
    }

    /**
     * Обратите внимание, что вызов parent::check можно вставить как в начале
     * этого метода, так и в конце.
     *
     * Это даёт значительно большую свободу действий, чем простой цикл по всем
     * объектам middleware. Например, middleware может изменить порядок
     * проверок, запустив свою проверку после всех остальных.
     */
    public function check(string $email, string $password): bool
    {
        if (time() > $this->currentTime + 60) {
            $this->request = 0;
            $this->currentTime = time();
        }

        $this->request++;

        if ($this->request > $this->requestPerMinute) {
            echo "ThrottlingMiddleware: Request limit exceeded!\n";
            die();
        }

        return parent::check($email, $password);
    }
}