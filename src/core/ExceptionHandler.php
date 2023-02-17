<?php

namespace Nils\QuizTee\core;

use Exception;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\HttpException;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;

class ExceptionHandler implements IExceptionHandler
{
    public function handleError(Request $request, \Exception $error): void
    {
        if ($error instanceof HttpException) {
            $this->handleHttpException($error);
        } else {
            $this->handleInternalServerError($error);
        }
    }

    private function handleInternalServerError(\Exception $error)
    {
        // TODO: Log error
        response()->json([
            'error' => 'Sorry something went wrong. Plese try again later! :(',
            'code' => 500
        ]);
    }

    private function handleHttpException(HttpException $error)
    {
        // TODO: Log info
        response()->json([
            'error' => $error->getMessage(),
            'code' => $error->getCode()
        ]);
    }
}
