<?php

namespace App\Pattern\Behavioral\Mediator;

use App\Pattern\Behavioral\Mediator\Component\Observer;
/**
 * Класс Диспетчера Событий выполняет функции Посредника и содержит логику
 * подписки и уведомлений. Хотя классический Посредник часто зависит от
 * конкретных классов компонентов, этот привязан только к их абстрактным интерфейсам.
 */
class EventDispatcher
{
    public static $eventDispatcher;

    /**
     * @var array
     */
    private $observers = [];

    public function __construct()
    {
        // Специальная группа событий для наблюдателей, которые хотят слушать
        // все события.
        $this->observers["*"] = [];
    }

    private function initEventGroup(string $event = '*')
    {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = [];
        }
    }

    private function getEventObservers(string $event = '*'): array
    {
        $this->initEventGroup($event);
        $group = $this->observers[$event];
        $all = $this->observers['*'];

        return array_merge($group, $all);
    }

    public function attach(Observer $observer, string $event = '*')
    {
        $this->initEventGroup($event);
        $this->observers[$event][] = $observer;
    }

    public function detach(Observer $observer, string $event = '*')
    {
        foreach ($this->getEventObservers($event) as $key => $eventObservers) {
            if ($eventObservers === $observer) {
                unset($this->observers[$event][$key]);
            }
        }
    }

    public function trigger(string $event, object $emitter, $data = null): void
    {
        echo "EventDispatcher: Broadcasting the '$event' event.\n";
        foreach ($this->getEventObservers($event) as $observer) {
            $observer->update($event, $emitter, $data);
        }
    }

    public static function get()
    {
        if (!self::$eventDispatcher) {
            self::$eventDispatcher = new EventDispatcher();
        }

        return self::$eventDispatcher;
    }
}