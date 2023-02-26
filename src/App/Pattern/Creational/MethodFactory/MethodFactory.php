<?php

namespace App\Pattern\Creational\MethodFactory;

use App\Pattern\Creational\MethodFactory\Creator\SocialNetworkPoster;

class MethodFactory
{
    public function __construct(public SocialNetworkPoster $creator)
    {
        $creator->post('Hello world!');
    }
}