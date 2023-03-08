<?php

namespace App\Controller;

use App\Pattern\Behavioral\Command\IMDBGenresScrapingCommand;
use App\Pattern\Behavioral\Command\Queue;
use App\Pattern\Behavioral\Cor\Middleware\RoleCheckMiddleware;
use App\Pattern\Behavioral\Cor\Middleware\Server;
use App\Pattern\Behavioral\Cor\Middleware\ThrottlingMiddleware;
use App\Pattern\Behavioral\Cor\Middleware\UserExistsMiddleware;
use App\Pattern\Behavioral\Iterator\CsvIterator;
use Symfony\Component\HttpFoundation\Response;

class Behavioral
{
    public function cor()
    {
        ob_start();
        /**
         * Клиентский код.
         */
        $server = new Server();
        $server->register('admin@example.com', 'admin_pass');
        $server->register('user@example.com', 'user_pass');

        // Все middleware соединены в цепочки. Клиент может построить различные
        // конфигурации цепочек в зависимости от своих потребностей.
        $middleware = new ThrottlingMiddleware(2);
        $middleware
            ->linkWith(new UserExistsMiddleware($server))
            ->linkWith(new RoleCheckMiddleware());

        // Сервер получает цепочку из клиентского кода.
        $server->setMiddleware($middleware);

        $email = 'admin@example.com';
        $password = 'admin_pass';
        $server->logIn($email, $password);

        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function command()
    {
        ob_start();
        $queue = Queue::get();

        if ($queue->isEmpty()) {
            $queue->add(new IMDBGenresScrapingCommand());
        }

        $queue->work();
        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function iterator()
    {
        $csv = new CsvIterator(__DIR__ . '/../Pattern/Behavioral/Iterator/Resource/cats.csv');
        $output = [];
        foreach ($csv as $elm) {
            $output[] = $elm;
        }
        return new Response(print_r($output,true), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}