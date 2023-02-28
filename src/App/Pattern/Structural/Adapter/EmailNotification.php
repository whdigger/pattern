<?php

namespace App\Pattern\Structural\Adapter;

class EmailNotification implements Notification
{
    private string $adminEmail;

    public function __construct(string $adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function send(string $title, string $message)
    {
        echo "Sent email with title '$title' to '{$this->adminEmail}' that says '$message'.";
    }
}