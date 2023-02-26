<?php

namespace App\Controller;

use App\Pattern\Creational\AbstractFactory\Creator\PHPTemplateFactory;
use App\Pattern\Creational\AbstractFactory\Page;
use App\Pattern\Creational\Builder\Builder;
use App\Pattern\Creational\Builder\Product\MysqlQueryBuilder;
use App\Pattern\Creational\MethodFactory\Creator\FacebookPoster;
use App\Pattern\Creational\MethodFactory\MethodFactory;
use App\Pattern\Creational\Prototype\Prototype;
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
}