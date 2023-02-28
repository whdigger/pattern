<?php

namespace App\Controller;

use App\Pattern\Structural\Adapter\Library\SlackApi;
use App\Pattern\Structural\Adapter\SlackNotificationAdapter;
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
}