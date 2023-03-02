<?php

namespace App\Pattern\Structural\Decorator;

use App\Pattern\Structural\Decorator\Component\InputFormat;

class Decorator {
    public function displayCommentAsAWebsite(InputFormat $format, string $text)
    {
        return $format->formatText($text);
    }
}