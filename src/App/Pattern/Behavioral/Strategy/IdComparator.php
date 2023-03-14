<?php
namespace App\Pattern\Behavioral\Strategy;

class IdComparator  implements Comparator
{
    public function compare($a, $b): int
    {
        return $a <=> $b;
    }
}