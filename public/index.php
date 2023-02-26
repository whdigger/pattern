<?php
chdir(dirname(__DIR__));

require_once './vendor/autoload.php';

use Framework\YamlLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $routes = (new YamlLoader())->getRoutes();
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());

    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());

//    // How to generate a SEO URL
//    $generator = new UrlGenerator($routes, $context);
//    $url = $generator->generate('foo_placeholder_route', array(
//        'id' => 123,
//    ));

    $controllerInfo = explode('::',$parameters['_controller']);

    $controller = new $controllerInfo[0];
    $action = $controllerInfo[1];
    $response = $controller->$action();

    $response->send();
} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
}