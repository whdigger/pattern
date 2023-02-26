<?php

namespace App\Pattern\Creational\Builder;

use App\Pattern\Creational\Builder\Product\SQLQueryBuilder;

class Builder
{
    /**
     * Обратите внимание, что клиентский код непосредственно использует объект
     * строителя. Назначенный класс Директора в этом случае не нужен, потому что
     * клиентский код практически всегда нуждается в различных запросах, поэтому
     * последовательность шагов конструирования непросто повторно использовать.
     *
     * Поскольку все наши строители запросов создают продукты одного типа (это
     * строка), мы можем взаимодействовать со всеми строителями, используя их общий
     * интерфейс. Позднее, если мы реализуем новый класс Строителя, мы сможем
     * передать его экземпляр существующему клиентскому коду, не нарушая его,
     * благодаря интерфейсу SQLQueryBuilder.
     */
    public function __construct(private SQLQueryBuilder $queryBuilder)
    {
    }

    public function findYoungPeople()
    {
        return $this->queryBuilder
            ->select('users', ['name', 'email', 'password'])
            ->where('age', 18, '>')
            ->where('age', 30, '<')
            ->limit(10, 20)
            ->getSql();
    }
}