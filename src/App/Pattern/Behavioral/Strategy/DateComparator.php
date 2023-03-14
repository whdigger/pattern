<?php
namespace App\Pattern\Behavioral\Strategy;

class DateComparator implements Comparator
{
    public function compare($a, $b): int
    {
        $aDate = new \DateTime($a['date']);
        $bDate = new \DateTime($b['date']);
        return $aDate <=> $bDate;
    }
}