<?php

namespace Nils\QuizTee\exception;

use Throwable;

class QuizAlreadyInProgressException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('There is already a quiz in progress. Please finish this at first!');
    }
}
