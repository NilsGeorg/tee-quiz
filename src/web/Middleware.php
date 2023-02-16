<?php

namespace Nils\QuizTee\web;


use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

/**
 * Just a simple middleware to keep a session
 */
class Middleware implements IMiddleware
{
    public function handle(Request $request): void
    {
        if (input('api-key') !== null) {
            $_SESSION['TOKEN'] = input('api-key');
        }
    }
}
