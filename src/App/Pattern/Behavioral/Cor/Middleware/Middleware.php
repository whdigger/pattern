<?php

namespace App\Pattern\Behavioral\Cor\Middleware;

/**
 * Классический паттерн CoR объявляет для объектов, составляющих цепочку,
 * единственную роль – Обработчик. В нашем примере давайте проводить различие
 * между middleware и конечным обработчиком приложения, который выполняется,
 * когда запрос проходит через все объекты middleware.
 *
 * Базовый класс Middleware объявляет интерфейс для связывания объектов
 * middleware в цепочку.
 */
abstract class Middleware
{
    /**
     * @var Middleware
     */
    private $next;

    /**
     * Этот метод можно использовать для построения цепочки объектов middleware.
     */
    public function linkWith(Middleware $next): Middleware
    {
        $this->next = $next;

        return $next;
    }

    /**
     * Подклассы должны переопределить этот метод, чтобы предоставить свои
     * собственные проверки. Подкласс может обратиться к родительской реализации
     * проверки, если сам не в состоянии обработать запрос.
     */
    public function check(string $email, string $password): bool
    {
        if (!$this->next) {
            return true;
        }

        return $this->next->check($email, $password);
    }
}