<?php

namespace App\Pattern\Structural\Most\Abstraction;

use App\Pattern\Structural\Most\Implement\Renderer;

class SimplePage extends Page
{
    public function __construct(Renderer $renderer, protected string $title, protected string $content)
    {
        parent::__construct($renderer);
    }

    public function view(): string
    {
        return $this->renderer->renderParts([
            $this->renderer->renderHeader(),
            $this->renderer->renderTitle($this->title),
            $this->renderer->renderTextBlock($this->content),
            $this->renderer->renderFooter()
        ]);
    }
}