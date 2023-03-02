<?php

namespace App\Pattern\Structural\Composite\Component;

/**
 * Базовый класс Компонент объявляет интерфейс для всех конкретных компонентов,
 * как простых, так и сложных.
 *
 * В нашем примере мы сосредоточимся на поведении рендеринга элементов DOM.
 */
abstract class FormElement
{
    protected $data;

    public function __construct(protected string $name, protected string $title)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * Каждый конкретный элемент DOM должен предоставить свою реализацию
     * рендеринга, но мы можем с уверенностью предположить, что все они будут
     * возвращать строки.
     */
    abstract public function render(): string;
}
