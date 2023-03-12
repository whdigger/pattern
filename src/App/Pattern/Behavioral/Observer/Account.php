<?php

namespace App\Pattern\Behavioral\Observer;

use SplSubject;
use SplObjectStorage;
use SplObserver;

class Account implements SplSubject
{
    private SplObjectStorage $observers;
    private $email;


    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }


    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }


    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function changeEmail(string $email): void
    {
        $this->email = $email;
        $this->notify();
    }

    public function notify(): void
    {
        /** @var SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}