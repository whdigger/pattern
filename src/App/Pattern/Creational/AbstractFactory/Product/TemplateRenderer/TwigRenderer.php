<?php

namespace App\Pattern\Creational\AbstractFactory\Product\TemplateRenderer;
/**
 * Отрисовщик шаблонов Twig.
 */
class TwigRenderer implements TemplateRenderer
{
    public function render(string $templateString, array $arguments = []): string
    {
        return $templateString;
    }
}