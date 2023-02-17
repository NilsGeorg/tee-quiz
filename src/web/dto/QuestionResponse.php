<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\web\AbstractResponse;

class QuestionResponse
{
    protected string $question;

    protected array $answers;

    public function __construct(QuestionEntity $questionEntity)
    {
        $this->id = $questionEntity->getId();
        $this->question = $questionEntity->getQuestion();
        $this->answers = AnswerResponse::from($questionEntity->getAnswers());
    }
}
