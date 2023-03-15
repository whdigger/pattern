<?php
namespace App\Pattern\Behavioral\Visitor\Component;

use App\Pattern\Behavioral\Visitor\Visitor;

interface Entity
{
    public function accept(Visitor $visitor): string;
}