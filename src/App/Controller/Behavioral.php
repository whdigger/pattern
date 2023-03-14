<?php

namespace App\Controller;

use App\Pattern\Behavioral\Command\IMDBGenresScrapingCommand;
use App\Pattern\Behavioral\Command\Queue;
use App\Pattern\Behavioral\Cor\Middleware\RoleCheckMiddleware;
use App\Pattern\Behavioral\Cor\Middleware\Server;
use App\Pattern\Behavioral\Cor\Middleware\ThrottlingMiddleware;
use App\Pattern\Behavioral\Cor\Middleware\UserExistsMiddleware;
use App\Pattern\Behavioral\Iterator\CsvIterator;
use App\Pattern\Behavioral\Mediator\Component\Logger;
use App\Pattern\Behavioral\Mediator\Component\OnboardingNotification;
use App\Pattern\Behavioral\Mediator\Component\UserRepository;
use App\Pattern\Behavioral\Mediator\EventDispatcher;
use App\Pattern\Behavioral\Memento\Command;
use App\Pattern\Behavioral\Memento\Editor;
use App\Pattern\Behavioral\Observer\Account;
use App\Pattern\Behavioral\Observer\AccountObserver;
use App\Pattern\Behavioral\State\OrderContext;
use App\Pattern\Behavioral\Strategy\CompareContext;
use App\Pattern\Behavioral\Strategy\IdComparator;
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
        return new Response(print_r($output, true), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function mediator()
    {
        ob_start();

        $repository = new UserRepository();
        $logger = new Logger;
        $onboarding = new OnboardingNotification('1@example.com');

        EventDispatcher::get()->attach($repository, 'facebook:update');
        EventDispatcher::get()->attach($logger);
        EventDispatcher::get()->attach($onboarding, 'users:created');

        $repository->initialize(__DIR__ . 'users.csv');
        $user = $repository->createUser([
            'name' => 'John Smith',
            'email' => 'john99@example.com',
        ]);
        $user->delete();

        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function memento()
    {
        ob_start();
        $editor = new Editor('Text', 'curX', 'curY', 'selectWidth');
        $command = new Command($editor);
        $command->makeBackup();
        $command->makeBackup();
        $command->undo();

        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function observer()
    {
        ob_start();
        $accountObserver = new AccountObserver();
        $account = new Account();
        $account->attach($accountObserver);
        $account->changeEmail('foo@bar.com');

        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function state()
    {
        $state = [];
        $orderContext = OrderContext::create();
        $state[] = $orderContext->toString();

        $orderContext->proceedToNext();
        $state[] = $orderContext->toString();

        $orderContext->proceedToNext();
        $state[] = $orderContext->toString();

        return new Response(implode("\n",$state), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function strategy()
    {
        $compareContext = new CompareContext(new IdComparator());
        $elements = $compareContext->executeStrategy([['id' => 2], ['id' => 1], ['id' => 3]]);

        return new Response(implode("\n", $elements), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}