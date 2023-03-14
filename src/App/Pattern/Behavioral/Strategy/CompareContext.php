<?php
namespace App\Pattern\Behavioral\Strategy;

class CompareContext
{
    public function __construct(private Comparator $comparator)
    {
    }

    public function executeStrategy(array $elements): array
    {
        uasort($elements, [$this->comparator, 'compare']);
        $result = [];
        array_walk_recursive($elements, function($value,$key) use (&$result) {
            $result[] = $value;
        });
        return $result;
    }
}