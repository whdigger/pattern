<?php

namespace App\Controller;

use Framework\YamlLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

class Main
{
    public function index()
    {
        $routes = (new YamlLoader())->getRoutes();
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $generator = new UrlGenerator($routes, $context);
        $url = $generator->generate('index');

        return new Response("This is Index page: $url", Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }
}