<?php

namespace Nils\QuizTee\persistence\entity;

/**
 * In real world the answers should contain a reference to the Question. Also they should have an index (like a, b, c).
 * With this index number and the question_id there should be a foreign key constraint so each question can only have
 * on index a and so on. Then there would be no need in presenting the answer id to the world and also checking the
 * answers would be much easier.
 */
final class AnswerEntity extends BaseEntity
{
    private string $answer;
    private bool $isCorrect;

    /**
     * @param string $answer
     * @param bool $isCorrect
     */
    public function __construct(string $answer, bool $isCorrect)
    {
        parent::__construct();
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * @param bool $isCorrect
     */
    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }
}