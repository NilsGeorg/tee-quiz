<?php

namespace Nils\QuizTee\domain;

use Nils\QuizTee\exception\BadRequestHttpException;
use Nils\QuizTee\exception\NoQuizInProgressException;
use Nils\QuizTee\exception\QuizAlreadyInProgressException;
use Nils\QuizTee\exception\UnauthorizedHttpException;
use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\persistence\entity\SessionEntity;
use Nils\QuizTee\persistence\entity\SessionQuestionEntity;
use Nils\QuizTee\persistence\entity\TokenEntity;
use Nils\QuizTee\persistence\repository\QuestionRepository;
use Nils\QuizTee\persistence\repository\SessionQuestionRepository;
use Nils\QuizTee\persistence\repository\SessionRepository;
use Nils\QuizTee\persistence\repository\TokenRepository;
use Nils\QuizTee\web\dto\AnswerRequest;
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

    /**
     * @param AnswerRequest $answerPosition
     * @return void
     */
    public function answer(TokenEntity $tokenEntity, AnswerRequest $answerPosition): void
    {
        $session = $this->getCurrentSession($tokenEntity);
        if ($session === null) {
            throw new NoQuizInProgressException();
        }

        /**
         * @var $openQuestion SessionQuestionEntity
         */
        $openQuestion = $this->getOpenQuestion($session);
        if ($openQuestion === null) {
            throw new BadRequestHttpException();
        }

        $answers = $openQuestion
            ->getQuestion()
            ->getAnswers()
            ->filter(function (AnswerEntity $answer) use ($answerPosition) {
                return in_array($answer->getOrderIndex(), $answerPosition->getPositions());
            });

        $this->sessionQuestionRepository->addAnswer($openQuestion, $answers);
    }

    public function getNextQuestion(TokenEntity $tokenEntity): ?QuestionEntity
    {
        $session = $this->getCurrentSession($tokenEntity);
        if ($session === null) {
            throw new NoQuizInProgressException();
        }

        $openQuestion = $this->getOpenQuestion($session);
        if ($openQuestion !== null) {
            return $openQuestion->getQuestion();
        }

        return $this->getLatestQuestion($session);
    }

    private function getCurrentSession(TokenEntity $tokenEntity): ?SessionEntity
    {
        return $this->sessionRepository->findOneBy(['token' => $tokenEntity, 'finished' => false]);
    }

    /**
     * @param SessionEntity $session
     * @return object|null
     */
    private function getOpenQuestion(SessionEntity $session): ?SessionQuestionEntity
    {
        return $this->sessionQuestionRepository->findOneBy(['session' => $session, 'answered' => false]);
    }

    private function getLatestQuestion(SessionEntity $session): ?QuestionEntity
    {
        $currentPosition = $this->sessionQuestionRepository->findHighestPositionBySession($session);

        return $this->questionRepository->findOneBy(['orderIndex' => $currentPosition + 1]);
    }
}
