<?php

namespace App\Pattern\Behavioral\State;


class StateDone implements State
{
    public function proceedToNext(OrderContext $context)
    {
    }

    public function toString(): string
    {
        return 'done';
    }
}