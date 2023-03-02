<?php

namespace App\Controller;

use App\Pattern\Structural\Adapter\Library\SlackApi;
use App\Pattern\Structural\Adapter\SlackNotificationAdapter;
use App\Pattern\Structural\Composite\Composite;
use App\Pattern\Structural\Most\Abstraction\ProductPage;
use App\Pattern\Structural\Most\Abstraction\SimplePage;
use App\Pattern\Structural\Most\Implement\HTMLRenderer;
use App\Pattern\Structural\Most\Implement\JsonRenderer;
use App\Pattern\Structural\Most\Product;
use Symfony\Component\HttpFoundation\Response;

class Structural
{
    public function adapter()
    {
        ob_start();
        echo "The same client code can work with other classes via adapter:\n";
        $slackApi = new SlackApi("example.com", "XXXXXXXX");
        $notification = new SlackNotificationAdapter($slackApi, "Example.com Developers");
        $notification->send("Website is down!",
            "<strong style='color:red;font-size: 50px;'>Alert!</strong> " .
            "Our website is not responding. Call admins and bring it up!");

        return new Response(ob_get_clean(), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function most()
    {
        ob_start();

        /**
         * Клиентский код может выполняться с любой предварительно сконфигурированной
         * комбинацией Абстракция+Реализация.
         */
        $HTMLRenderer = new HTMLRenderer();
        $JSONRenderer = new JsonRenderer();

        $page = new SimplePage($HTMLRenderer, "Home", "Welcome to our website!");
        $output = "HTML view of a simple content page:\n";
        $output .= $page->view();

        /**
         * При необходимости Абстракция может заменить связанную Реализацию во время
         * выполнения.
         */
        $page->changeRenderer($JSONRenderer);
        $output .= "JSON view of a simple content page, rendered with the same client code:\n";
        $output .= $page->view();

        $product = new Product("123", "Star Wars, episode1",
            "A long time ago in a galaxy far, far away...",
            "/images/star-wars.jpeg", 39.95);

        $page = new ProductPage($HTMLRenderer, $product);
        $output .= "HTML view of a product page, same client code:\n";
        $output .= $page->view();

        $page->changeRenderer($JSONRenderer);
        $output .= "JSON view of a simple content page, with the same client code:\n";
        $output .= $page->view();

        return new Response($output, Response::HTTP_OK, ['content-type' => 'text/html']);
    }

    public function composite()
    {
        $composite = new Composite();

        $form = $composite->getProductForm();
        $composite->loadProductData($form);

        return new Response($composite->renderProduct($form), Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}