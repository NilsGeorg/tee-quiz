<?php

namespace Nils\QuizTee\web;

use Nils\QuizTee\util\SessionStorage;
use ReallySimpleJWT\Token;

class AuthController
{
    // TODO: add some config files for the secret
    private string $secret = 'super-secret';

    private SessionStorage $sessionStorage;

    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();
    }

    public function login(string $user)
    {
        $token = Token::create($user, $this->secret, time() + 9999999, 'quiz');

        $this->sessionStorage->startSession();

        return $token;
    }
}