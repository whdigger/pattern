<?php

namespace App\Pattern\Behavioral\Cor\Middleware;

/**
 * Это Конкретное Middleware проверяет, имеет ли пользователь, связанный с
 * запросом, достаточные права доступа.
 */
class RoleCheckMiddleware extends Middleware
{
    public function check(string $email, string $password): bool
    {
        if ($email === "admin@example.com") {
            echo "RoleCheckMiddleware: Hello, admin!\n";

            return true;
        }
        echo "RoleCheckMiddleware: Hello, user!\n";

        return parent::check($email, $password);
    }
}