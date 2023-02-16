<?php

namespace Nils\QuizTee\persistence\entity;

final class QuestionEntity extends BaseEntity
{
    private string $question;

    // Should be an array collection
    private array $answers;

    // This should be unique and have an incrementing order
    private int $order;

    /**
     * @param string $question
     * @param array $answers
     */
    public function __construct(string $question, array $answers, int $order)
    {
        parent::__construct();
        $this->question = $question;
        $this->answers = $answers;
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param array $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
}