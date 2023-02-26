<?php

namespace App\Pattern\Creational\AbstractFactory\Product\TitleTemplate;

/**
 * А этот Конкретный Продукт предоставляет шаблоны заголовков страниц
 * PHPTemplate.
 */
class PHPTemplateTitleTemplate implements TitleTemplate
{
    public function getTemplateString(): string
    {
        return "<h1><?= \$title; ?></h1>";
    }
}