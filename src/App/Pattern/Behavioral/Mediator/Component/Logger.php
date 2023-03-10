<?php

namespace App\Pattern\Behavioral\Mediator\Component;
/**
 * Этот Конкретный Компонент регистрирует все события, на которые он подписан.
 */
class Logger implements Observer
{
    public function update(string $event, object $emitter, $data = null)
    {
        echo "Logger: I've written '$event' entry to the log.\n";
    }
}