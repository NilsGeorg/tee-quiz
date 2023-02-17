<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\domain\SummaryItem;
use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\web\AbstractResponse;

class SummaryItemResponse extends AbstractResponse
{
    protected string $question;

    /**
     * @var SummaryAnswerResponse[]
     */
    protected array $summaryAnswerResponse = array();

    public function addAnswerResponse(SummaryAnswerResponse $summaryAnswerResponse)
    {
        $this->summaryAnswerResponse[] = $summaryAnswerResponse;
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
    public function getSummaryAnswerResponse(): array
    {
        return $this->summaryAnswerResponse;
    }

    /**
     * @param array $summaryAnswerResponse
     */
    public function setSummaryAnswerResponse(array $summaryAnswerResponse): void
    {
        $this->summaryAnswerResponse = $summaryAnswerResponse;
    }

    public static function from(SummaryItem $summaryItem): SummaryItemResponse
    {
        $summaryItemResponse = new SummaryItemResponse();

        $summaryItemResponse->setQuestion($summaryItem->getQuestionEntity()->getQuestion());

        /**
         * @var $answer AnswerEntity
         */
        foreach ($summaryItem->getQuestionEntity()->getAnswers() as $answer) {
            $choosen = in_array($answer->getId(), $summaryItem->getGivenAnswers());

            $summeryAnswerResponse = new SummaryAnswerResponse(
                $answer->getOrderIndex(),
                $answer->getAnswer(),
                $answer->isCorrect(),
                $choosen
            );

            $summaryItemResponse->addAnswerResponse($summeryAnswerResponse);
        }

        return $summaryItemResponse;
    }
}
