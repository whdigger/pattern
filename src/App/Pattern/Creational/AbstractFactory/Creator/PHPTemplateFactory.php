<?php

namespace App\Pattern\Creational\AbstractFactory\Creator;

use App\Pattern\Creational\AbstractFactory\Product\PageTemplate\PageTemplate;
use App\Pattern\Creational\AbstractFactory\Product\PageTemplate\PHPTemplatePageTemplate;
use App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer\PHPTemplateRenderer;
use App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer\TemplateRenderer;
use App\Pattern\Creational\AbstractFactory\Product\TitleTemplate\PHPTemplateTitleTemplate;
use App\Pattern\Creational\AbstractFactory\Product\TitleTemplate\TitleTemplate;

/**
 * А эта Конкретная Фабрика создает шаблоны PHPTemplate.
 */
class PHPTemplateFactory implements TemplateFactory
{
    public function createTitleTemplate(): TitleTemplate
    {
        return new PHPTemplateTitleTemplate();
    }

    public function createPageTemplate(): PageTemplate
    {
        return new PHPTemplatePageTemplate($this->createTitleTemplate());
    }

    public function getRenderer(): TemplateRenderer
    {
        return new PHPTemplateRenderer();
    }
}