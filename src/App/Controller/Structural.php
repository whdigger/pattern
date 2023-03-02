<?php

namespace App\Controller;

use App\Pattern\Structural\Adapter\Library\SlackApi;
use App\Pattern\Structural\Adapter\SlackNotificationAdapter;
use App\Pattern\Structural\Composite\Composite;
use App\Pattern\Structural\Decorator\Component\TextInput;
use App\Pattern\Structural\Decorator\DangerousHTMLTagsFilter;
use App\Pattern\Structural\Decorator\Decorator;
use App\Pattern\Structural\Decorator\MarkdownFormat;
use App\Pattern\Structural\Decorator\PlainTextFilter;
use App\Pattern\Structural\Fasad\Authorizator;
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

    public function decorator()
    {
        $composite = new Decorator();
        $outputString = '';

        /**
         * Модули форматирования пользовательского ввода очень удобны при работе с
         * контентом, создаваемым пользователями. Отображение такого контента «как есть»
         * может быть очень опасным, особенно когда его могут создавать анонимные
         * пользователи (например, комментарии). Ваш сайт не только рискует получить
         * массу спам-ссылок, но также может быть подвергнут XSS-атакам.
         */
        $dangerousComment = <<<HERE
Hello! Nice blog post!
Please visit my <a href='http://www.iwillhackyou.com'>homepage</a>.
<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

        /**
         * Наивное отображение комментариев (небезопасное).
         */
        $naiveInput = new TextInput();

        $outputString .= "Website renders comments without filtering (unsafe):\n";
        $outputString .= $composite->displayCommentAsAWebsite($naiveInput, $dangerousComment);
        $outputString .= "\n\n\n";

        /**
         * Отфильтрованное отображение комментариев (безопасное).
         */
        $filteredInput = new PlainTextFilter($naiveInput);
        $outputString .= "Website renders comments after stripping all tags (safe):\n";
        $outputString .= $composite->displayCommentAsAWebsite($filteredInput, $dangerousComment);
        $outputString .= "\n\n\n";


        /**
         * Декоратор позволяет складывать несколько входных форматов для получения
         * точного контроля над отображаемым содержимым.
         */
        $dangerousForumPost = <<<HERE
# Welcome

This is my first post on this **gorgeous** forum.

<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

        /**
         * Наивное отображение сообщений (небезопасное, без форматирования).
         */
        $naiveInput = new TextInput();
        $outputString .= "Website renders a forum post without filtering and formatting (unsafe, ugly):\n";
        $outputString .= $composite->displayCommentAsAWebsite($naiveInput, $dangerousForumPost);
        $outputString .= "\n\n\n";

        /**
         * Форматтер Markdown + фильтрация опасных тегов (безопасно, красиво).
         */
        $text = new TextInput();
        $markdown = new MarkdownFormat($text);
        $filteredInput = new DangerousHTMLTagsFilter($markdown);
        $outputString .= "Website renders a forum post after translating markdown markup and filtering some dangerous HTML tags and attributes (safe, pretty):\n";
        $outputString .= $composite->displayCommentAsAWebsite($filteredInput, $dangerousForumPost);
        $outputString .= "\n\n\n";

        return new Response($outputString, Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    public function fasad()
    {
        // Вымышленный пользователь
        $username = "Vasya";
        $passwd = "qwerty";

        $error = '';
        try {
            $auth = new Authorizator();
            $auth->authorizate($username, $passwd);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return new Response($error, Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}