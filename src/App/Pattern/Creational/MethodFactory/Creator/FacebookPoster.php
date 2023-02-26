<?php

namespace App\Pattern\Creational\MethodFactory\Creator;

use App\Pattern\Creational\MethodFactory\Product\FacebookConnector;
use App\Pattern\Creational\MethodFactory\Product\SocialNetworkConnector;

/**
 * Этот Конкретный Создатель поддерживает Facebook
 * класс который фактически использует Клиент.
 */
class FacebookPoster extends SocialNetworkPoster
{
    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}