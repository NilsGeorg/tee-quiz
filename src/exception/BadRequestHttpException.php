<?php

namespace Nils\QuizTee\exception;

use Pecee\SimpleRouter\Exceptions\HttpException;
use Throwable;

class BadRequestHttpException extends HttpException
{
    public function __construct(string $message = "", ?Throwable $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
