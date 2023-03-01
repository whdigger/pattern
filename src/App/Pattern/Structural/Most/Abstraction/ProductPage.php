<?php

namespace App\Pattern\Structural\Most\Abstraction;

use App\Pattern\Structural\Most\Implement\Renderer;
use App\Pattern\Structural\Most\Product;

class ProductPage extends Page
{
    public function __construct(Renderer $renderer, protected Product $product)
    {
        parent::__construct($renderer);
    }

    public function view(): string
    {
        return $this->renderer->renderParts([
            $this->renderer->renderHeader(),
            $this->renderer->renderTitle($this->product->getTitle()),
            $this->renderer->renderTextBlock($this->product->getDescription()),
            $this->renderer->renderImage($this->product->getImage()),
            $this->renderer->renderLink("/cart/add/" . $this->product->getId(), "Add to cart"),
            $this->renderer->renderFooter()
        ]);
    }
}
