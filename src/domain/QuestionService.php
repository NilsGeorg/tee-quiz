<?php

namespace Nils\QuizTee\domain;

use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\persistence\repository\QuestionRepository;
use Nils\QuizTee\util\SessionStorage;

class QuestionService
{
    private QuestionRepository $questionRepository;
    private SessionStorage $sessionStorage;

    public function __construct()
    {
        // would normally do this with DI, but in this small example this should be sufficient
        $this->questionRepository = new QuestionRepository();
        $this->sessionStorage = new SessionStorage();
    }

    public function start(): QuestionEntity
    {
        $this->sessionStorage->resetQuiz();

        return $this->questionRepository->findFirstQuestion();
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
            $nextQuestion = $this->questionRepository->findFirstQuestion();
        } else {
            $nextQuestion = $this->questionRepository->findNextQuestion($currentQuestionOrder);
        }

        return $nextQuestion;
    }
}