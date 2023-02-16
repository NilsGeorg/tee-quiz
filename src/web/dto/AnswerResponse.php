<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\web\AbstractResponse;

class AnswerResponse extends AbstractResponse
{
    protected string $id;
    protected string $answer;

    public function __construct(AnswerEntity $answerEntity)
    {
        $this->answer = $answerEntity->getAnswer();
        $this->id = $answerEntity->getId();
    }

    /**
     * @param AnswerEntity[] $answerEntities
     * @return AnswerResponse[]
     */
    public static function from(array $answerEntities)
    {
        $answers = array();

        foreach ($answerEntities as $answerEntity) {
            $answers[] = new AnswerResponse($answerEntity);
        }

        return $answers;
    }
}