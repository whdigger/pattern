<?php

namespace App\Pattern\Creational\AbstractFactory\Product\PageTemplate;

/**
 * Это еще один тип Абстрактного Продукта, который описывает шаблоны целых
 * страниц.
 */
interface PageTemplate
{
    public function getTemplateString(): string;
}