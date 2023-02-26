<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Behavioral
{
    public function about()
    {
        return new Response("This is About page", Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }

    public function index()
    {
        return new Response("This is Index page", Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }
}