<?php

namespace Nils\QuizTee\domain;

use Nils\QuizTee\exception\QuizAlreadyInProgressException;
use Nils\QuizTee\exception\UnauthorizedHttpException;
use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\persistence\entity\SessionEntity;
use Nils\QuizTee\persistence\entity\SessionQuestionEntity;
use Nils\QuizTee\persistence\entity\TokenEntity;
use Nils\QuizTee\persistence\repository\QuestionRepository;
use Nils\QuizTee\persistence\repository\SessionQuestionRepository;
use Nils\QuizTee\persistence\repository\SessionRepository;
use Nils\QuizTee\persistence\repository\TokenRepository;
use Nils\QuizTee\web\Middleware;

class QuestionService
{
    private QuestionRepository $questionRepository;
    private SessionRepository $sessionRepository;
    private SessionQuestionRepository $sessionQuestionRepository;
    protected TokenRepository $tokenRepository;

    public function __construct(
        QuestionRepository        $questionRepository = new QuestionRepository(),
        SessionRepository         $sessionRepository = new SessionRepository(),
        SessionQuestionRepository $sessionQuestionRepository = new SessionQuestionRepository(),
        TokenRepository           $tokenRepository = new TokenRepository()
    )
    {
        $this->questionRepository = $questionRepository;
        $this->sessionRepository = $sessionRepository;
        $this->sessionQuestionRepository = $sessionQuestionRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function start(TokenEntity $tokenEntity): QuestionEntity
    {
        $session = $this->getCurrentSession($tokenEntity);
        if ($session !== null) {
            throw new QuizAlreadyInProgressException();
        }

        $session = $this->sessionRepository->create($this->getToken());

        $startQuestion = $this->questionRepository->findFirst();
        $this->sessionQuestionRepository->create($startQuestion, $session);

        return $startQuestion;
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

    public function answer(array $answerIds): void
    {
        $currentQuestionOrder = $this->sessionStorage->getCurrentQuestionNumber();
        $this->sessionStorage->addAnswer($currentQuestionOrder, $answerIds);
    }

    public function getNextQuestion(): ?QuestionEntity
    {
        $nextQuestion = $this->getNext();

        if ($nextQuestion !== null) {
            $this->sessionStorage->setCurrentQuestionNumber($nextQuestion->getOrder());
        }

        return $nextQuestion;
    }

    private function getNext(): ?QuestionEntity
    {
        $currentQuestionOrder = $this->sessionStorage->getCurrentQuestionNumber();

        /**
         * @var $nextQuestion QuestionEntity
         */
        if ($currentQuestionOrder === null) {
            $nextQuestion = $this->questionRepository->findFirst();
        } else {
            $nextQuestion = $this->questionRepository->findNext($currentQuestionOrder);
        }

        return $nextQuestion;
    }

    private function getCurrentSession(TokenEntity $tokenEntity): ?SessionEntity
    {
        return $this->sessionRepository->findOneBy(['token' => $tokenEntity, 'finished' => 'false']);
    }
}
