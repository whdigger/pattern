<?php

namespace App\Controller;

use App\Pattern\Creational\AbstractFactory\Creator\PHPTemplateFactory;
use App\Pattern\Creational\AbstractFactory\Page;
use App\Pattern\Creational\Builder\Builder;
use App\Pattern\Creational\Builder\Product\MysqlQueryBuilder;
use App\Pattern\Creational\MethodFactory\Creator\FacebookPoster;
use App\Pattern\Creational\MethodFactory\MethodFactory;
use App\Pattern\Creational\Prototype\Prototype;
use App\Pattern\Creational\Singleton\Config;
use App\Pattern\Creational\Singleton\Logger;
use Symfony\Component\HttpFoundation\Response;

class Creational
{
    public function methodFactory()
    {
        ob_start();
        echo "Testing FacebookPoster:\n";
        new MethodFactory(new FacebookPoster("john_smith", "******"));
        echo "\n\n";
        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function abstractFactory()
    {
        $page = new Page('Sample page', 'This is the body.');
        return new Response($page->render(new PHPTemplateFactory()), Response::HTTP_OK, ['content-type' => 'text/html']);
    }

    public function builder()
    {
        $query = new Builder(new MysqlQueryBuilder());
        return new Response($query->findYoungPeople(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function prototype()
    {
        $prototype = new Prototype();
        return new Response($prototype->get(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function singleton()
    {
        Logger::log("Started!");

        // Сравниваем значения одиночки-Логгера.

        $l1 = Logger::getInstance();
        $l2 = Logger::getInstance();
        if ($l1 === $l2) {
            Logger::log("Logger has a single instance.");
        } else {
            Logger::log("Loggers are different.");
        }

        // Проверяем, как одиночка-Конфигурация сохраняет данные...
        $config1 = Config::getInstance();
        $login = "test_login";
        $password = "test_password";
        $config1->setValue("login", $login);
        $config1->setValue("password", $password);

        // ...и восстанавливает их.
        $config2 = Config::getInstance();
        if ($login == $config2->getValue("login") &&
            $password == $config2->getValue("password")
        ) {
            Logger::log("Config singleton also works fine.");
        }

        Logger::log("Finished!");
        return new Response(Logger::getMessage(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}