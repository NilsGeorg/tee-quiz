<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\web\AbstractResponse;

class SummaryAnswerResponse extends AbstractResponse
{
    protected int $position;
    protected string $answer;
    protected bool $correct;
    protected bool $choosen;

    /**
     * @param int $position
     * @param string $answer
     * @param bool $correct
     * @param bool $choosen
     */
    public function __construct(int $position, string $answer, bool $correct, bool $choosen)
    {
        $this->position = $position;
        $this->answer = $answer;
        $this->correct = $correct;
        $this->choosen = $choosen;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
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
        return $this->correct;
    }

    /**
     * @param bool $correct
     */
    public function setCorrect(bool $correct): void
    {
        $this->correct = $correct;
    }

    /**
     * @return bool
     */
    public function isChoosen(): bool
    {
        return $this->choosen;
    }

    /**
     * @param bool $choosen
     */
    public function setChoosen(bool $choosen): void
    {
        $this->choosen = $choosen;
    }
}
