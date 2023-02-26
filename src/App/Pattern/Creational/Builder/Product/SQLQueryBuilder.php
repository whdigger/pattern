<?php

namespace App\Pattern\Creational\Builder\Product;

interface SQLQueryBuilder {
    public function select(string $table, array $fields): SQLQueryBuilder;
    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder;
    public function limit(int $start, int $offset): SQLQueryBuilder;
    public function getSql(): string;
}