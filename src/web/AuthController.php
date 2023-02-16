<?php

namespace Nils\QuizTee\web;

use Nils\QuizTee\persistence\repository\TokenRepository;
use ReallySimpleJWT\Token;

class AuthController
{
    // TODO: add some config files for the secret
    private string $secret = 'sec!ReT423*&';
    private int $year = 31_536_000;

    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository = new TokenRepository())
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function login(string $user)
    {
        $token = Token::create($user, $this->secret, time() + $this->year, 'quiz');

        $this->tokenRepository->create($token);

        return $token;
    }
}
