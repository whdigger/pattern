<?php

namespace App\Pattern\Structural\Most;

/**
 * Вспомогательный класс для класса ProductPage.
 */
class Product
{
    public function __construct(
        private string $id,
        private string $title,
        private string $description,
        private string $image,
        private float  $price
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
