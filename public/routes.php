<?php

use Nils\QuizTee\web\AuthController;
use Nils\QuizTee\core\ExceptionHandler as CustomExceptionHandler;
use Nils\QuizTee\web\Middleware;
use Nils\QuizTee\web\QuestionController;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::group(['prefix' => '/', 'exceptionHandler' => CustomExceptionHandler::class], function () {
    SimpleRouter::get('test', [\Nils\QuizTee\web\TestController::class, 'test']);

    SimpleRouter::get('login/{user}', [AuthController::class, 'login']);

    SimpleRouter::group(['middleware' => Middleware::class, 'prefix' => 'question'], function () {
        SimpleRouter::get('/start', [QuestionController::class, 'start']);
        SimpleRouter::post('/answer-next', [QuestionController::class, 'answerAndNext']);
        SimpleRouter::post('/answer', [QuestionController::class, 'answer']);
        SimpleRouter::get('/next', [QuestionController::class, 'next']);
        SimpleRouter::get('/summary', [QuestionController::class, 'summary']);
    });
});
