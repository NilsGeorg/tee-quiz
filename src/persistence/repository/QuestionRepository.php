<?php

namespace Nils\QuizTee\persistence\repository;

use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\persistence\entity\QuestionEntity;

class QuestionRepository
{

    // TODO: Save questions as Json String and load to object so ids don't change
    private string $jsonQuestions = '{"id":"63ee3c6cf29be","question":"1 + 1","answers":[{"id":"63ee3c6cf29bb","answer":"1"},{"id":"63ee3c6cf29bd","answer":"2"}]}';
    /**
     * @var QuestionEntity[]
     */
    private array $questions;

    public function __construct()
    {
        $this->questions = $this->generateQuestions();
    }

    public function findFirstQuestion(): QuestionEntity
    {
        return $this->questions[0];
    }

    public function findAllQuestion(): array
    {
        return $this->questions;
    }

    public function findQuestionById(string $uuid): ?QuestionEntity
    {
        foreach ($this->questions as $question) {
            if ($question->getId() === $uuid) {
                return $question;
            }
        }

        return null;
    }

    public function findNextQuestion(int $current): ?QuestionEntity
    {
        // this is not really save as if we skip some numbers we would end with an empty result
        foreach ($this->questions as $question) {
            if ($question->getOrder() === $current + 1) {
                return $question;
            }
        }

        return null;
    }

    /**
     * @return QuestionEntity[]
     */
    private function generateQuestions(): array
    {
        // could be some json decode
        return array(
            new QuestionEntity(
                '1 + 1',
                array(
                    new AnswerEntity('1', false),
                    new AnswerEntity('2', true)
                ),
                1
            ), new QuestionEntity(
                '2 + 2',
                array(
                    new AnswerEntity('3', false),
                    new AnswerEntity('4', true)
                ),
                2
            )
        );

    }
}
