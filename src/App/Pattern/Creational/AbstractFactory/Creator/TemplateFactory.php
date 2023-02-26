<?php

namespace App\Pattern\Creational\AbstractFactory\Creator;

use App\Pattern\Creational\AbstractFactory\Product\PageTemplate\PageTemplate;
use App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer\TemplateRenderer;
use App\Pattern\Creational\AbstractFactory\Product\TitleTemplate\TitleTemplate;

interface TemplateFactory
{
    public function createTitleTemplate(): TitleTemplate;

    public function createPageTemplate(): PageTemplate;

    public function getRenderer(): TemplateRenderer;
}