<?php

namespace Nils\QuizTee\web;

use Nils\QuizTee\domain\QuestionService;
use Nils\QuizTee\exception\BadRequestHttpException;
use Nils\QuizTee\exception\UnauthorizedHttpException;
use Nils\QuizTee\persistence\entity\TokenEntity;
use Nils\QuizTee\persistence\repository\TokenRepository;
use Nils\QuizTee\web\dto\AnswerRequest;
use Nils\QuizTee\web\dto\QuestionResponse;
use Nils\QuizTee\web\dto\SummaryResponse;

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
        $question = $this->questionService->getNextQuestion($this->getToken());
        return json_encode(new QuestionResponse($question), true);
    }

    public function answer()
    {
        if (!input()->exists("answers")) {
            throw new BadRequestHttpException();
        }

        $request = AnswerRequest::from(input("answers"));

        $this->questionService->answer($this->getToken(), $request);
    }

    public function answerAndNext(): string
    {
        $this->answer();

        $question = $this->questionService->getNextQuestion($this->getToken());
        if ($question !== null) {
            return json_encode(new QuestionResponse($question), true);
        } else {
            // Won't go for correct hateoas so just redirect to the finish
            // also should be replaced by named route
            redirect('/question/summary');
            return '';
        }
    }

    public function summary(): SummaryResponse
    {
        $summary = $this->questionService->createSummary($this->getToken());

        return SummaryResponse::from($summary);
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
