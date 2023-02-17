<?php

namespace Nils\QuizTee\domain;

use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\persistence\entity\QuestionEntity;
use Ramsey\Uuid\Uuid;

class SummaryItem
{
    private $points = 0;

    private QuestionEntity $questionEntity;
    /**
     * @var Uuid[]
     */
    private array $givenAnswers;

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * @return QuestionEntity
     */
    public function getQuestionEntity(): QuestionEntity
    {
        return $this->questionEntity;
    }

    /**
     * @param QuestionEntity $questionEntity
     */
    public function setQuestionEntity(QuestionEntity $questionEntity): void
    {
        $this->questionEntity = $questionEntity;
    }

    /**
     * @return array
     */
    public function getGivenAnswers(): array
    {
        return $this->givenAnswers;
    }

    /**
     * @param array $givenAnswers
     */
    public function setGivenAnswers(array $givenAnswers): void
    {
        $this->givenAnswers = $givenAnswers;
    }
}
