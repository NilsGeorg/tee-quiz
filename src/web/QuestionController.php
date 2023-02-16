<?php

namespace Nils\QuizTee\web;

use Nils\QuizTee\domain\QuestionService;
use Nils\QuizTee\exception\UnauthorizedHttpException;
use Nils\QuizTee\persistence\entity\TokenEntity;
use Nils\QuizTee\persistence\repository\TokenRepository;
use Nils\QuizTee\web\dto\QuestionResponse;

class QuestionController
{

    protected QuestionService $questionService;
    protected TokenRepository $tokenRepository;

    public function __construct(
        QuestionService $questionService = new QuestionService(),
        TokenRepository $tokenRepository = new TokenRepository()
    )
    {
        $this->questionService = $questionService;
        $this->tokenRepository = $tokenRepository;
    }

    public function start(): string
    {
        $question = $this->questionService->start($this->getToken());

        return json_encode(new QuestionResponse($question), true);
    }

    public function next()
    {
        $question = $this->questionService->getNextQuestion();
        return json_encode(new QuestionResponse($question), true);
    }

    public function answer()
    {
        // Should throw an exception if no answers are passed
        //if(input()->exists("answers"))

        // could be transformed into a dto
        $answersIds = input("answers");
        $this->questionService->answer($answersIds);
    }

    public function answerAndNext(): string
    {
        $this->answer();

        $question = $this->questionService->getNextQuestion();
        if ($question !== null) {
            return json_encode(new QuestionResponse($question), true);
        } else {
            // Won't go for correct hateoas so just redirect to the finish
            // also should be replaced by named route
            redirect('/question/summary');
        }
    }

    public function summary()
    {
        // Todo: Calculate points and print the answers
    }

    private function getToken(): TokenEntity
    {
        $jwt = Middleware::getApiKey(request());

        $token = $this->tokenRepository->findOneBy(['jwt' => $jwt]);
        if ($token === null) {
            throw new UnauthorizedHttpException();
        }

        return $token;
    }
}
