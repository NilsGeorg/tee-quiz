<?php

namespace Nils\QuizTee\web;

use Nils\QuizTee\exception\BadRequestHttpException;

class TestController
{
    public function test()
    {
        throw new BadRequestHttpException();
    }
}
