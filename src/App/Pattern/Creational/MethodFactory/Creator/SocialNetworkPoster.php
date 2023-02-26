<?php

namespace App\Pattern\Creational\MethodFactory\Creator;

use App\Pattern\Creational\MethodFactory\Product\SocialNetworkConnector;

abstract class SocialNetworkPoster
{
    public function __construct(protected string $login, protected string $password)
    {
    }

    /**
     * Фактический фабричный метод. Обратите внимание, что он возвращает
     * абстрактный коннектор. Это позволяет подклассам возвращать любые
     * конкретные коннекторы без нарушения контракта суперкласса.
     */
    abstract public function getSocialNetwork(): SocialNetworkConnector;

    /**
     * Когда фабричный метод используется внутри бизнес-логики Создателя,
     * подклассы могут изменять логику косвенно, возвращая из фабричного метода
     * различные типы коннекторов.
     */
    public function post($content): void
    {
        // Вызываем фабричный метод для создания объекта Продукта...
        $network = $this->getSocialNetwork();
        // ...а затем используем его по своему усмотрению.
        $network->logIn();
        $network->createPost($content);
        $network->logout();
    }
}