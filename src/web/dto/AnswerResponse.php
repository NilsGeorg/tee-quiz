<?php

namespace Nils\QuizTee\web\dto;

use Doctrine\Common\Collections\Collection;
use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\web\AbstractResponse;

class AnswerResponse extends AbstractResponse
{
    protected string $position;
    protected string $answer;

    public function __construct(AnswerEntity $answerEntity)
    {
        $this->answer = $answerEntity->getAnswer();
        $this->position = $answerEntity->getOrderIndex();
    }

    /**
     * @param Collection<AnswerEntity> $answerEntities
     * @return AnswerResponse[]
     */
    public static function from(Collection $answerEntities): array
    {
        $answers = array();

        foreach ($answerEntities as $answerEntity) {
            $answers[] = new AnswerResponse($answerEntity);
        }

        return $answers;
    }
}
