<?php

namespace App\Pattern\Creational\AbstractFactory\Creator;

use App\Pattern\Creational\AbstractFactory\Product\PageTemplate\PageTemplate;
use App\Pattern\Creational\AbstractFactory\Product\PageTemplate\TwigPageTemplate;
use App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer\TemplateRenderer;
use App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer\TwigRenderer;
use App\Pattern\Creational\AbstractFactory\Product\TitleTemplate\TitleTemplate;
use App\Pattern\Creational\AbstractFactory\Product\TitleTemplate\TwigTitleTemplate;

/**
 * Каждая Конкретная Фабрика соответствует определённому варианту (или
 * семейству) продуктов.
 *
 * Эта Конкретная Фабрика создает шаблоны Twig.
 */
class TwigTemplateFactory implements TemplateFactory
{
    public function createTitleTemplate(): TitleTemplate
    {
        return new TwigTitleTemplate();
    }

    public function createPageTemplate(): PageTemplate
    {
        return new TwigPageTemplate($this->createTitleTemplate());
    }

    public function getRenderer(): TemplateRenderer
    {
        return new TwigRenderer();
    }
}
