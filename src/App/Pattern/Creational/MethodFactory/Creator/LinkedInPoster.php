<?php

namespace App\Pattern\Creational\MethodFactory\Creator;

use App\Pattern\Creational\MethodFactory\Product\LinkedInConnector;
use App\Pattern\Creational\MethodFactory\Product\SocialNetworkConnector;

class LinkedInPoster extends SocialNetworkPoster
{
    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new LinkedInConnector($this->login, $this->password);
    }
}