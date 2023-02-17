<?php

namespace Nils\QuizTee\exception;

use Throwable;

class NoQuizInProgressException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('Currently there is no quiz in progress. Please start a quiz at first!');
    }
}
