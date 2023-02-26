<?php

namespace App\Pattern\Creational\Prototype;

class Prototype
{
    public function get(): string
    {
        $author = new Author("John Smith");
        $page = new Page("Tip of the day", "Keep calm and carry on.", $author);
        $page->addComment("Nice tip, thanks!");

        $draft = clone $page;
        $result = "Dump of the clone. Note that the author is now referencing two objects.\n\n";
        return $result . print_r($draft, true);
    }
}