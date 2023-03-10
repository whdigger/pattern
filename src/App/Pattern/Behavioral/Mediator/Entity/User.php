<?php

namespace App\Pattern\Behavioral\Mediator\Entity;
use App\Pattern\Behavioral\Mediator\EventDispatcher;

class User
{
    public $attributes = [];

    public function update($data): void
    {
        $this->attributes = array_merge($this->attributes, $data);
    }

    /**
     * Все объекты могут вызывать события.
     */
    public function delete(): void
    {
        echo "User: I can now delete myself without worrying about the repository.\n";
        EventDispatcher::get()->trigger('users:deleted', $this, $this);
    }
}