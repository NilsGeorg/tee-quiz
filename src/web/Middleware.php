<?php

namespace Nils\QuizTee\web;


use Nils\QuizTee\exception\UnauthorizedHttpException;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

/**
 * Just a simple middleware to keep a session
 */
class Middleware implements IMiddleware
{
    private const HEADER_API_KEY = 'http-x-api-key';

    public function handle(Request $request): void
    {
        self::getApiKey($request);
    }

    // TODO: Move into 'security' class
    public static function getApiKey(Request $request): string
    {
        $apiKey = $request->getHeader(self::HEADER_API_KEY);

        if ($apiKey === null) {
            throw new UnauthorizedHttpException();
        }

        return $apiKey;
    }
}
