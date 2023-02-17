<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\domain\Summary;
use Nils\QuizTee\domain\SummaryItem;
use Nils\QuizTee\web\AbstractResponse;

class SummaryResponse extends AbstractResponse
{
    protected int $totalPoints;

    /**
     * @var SummaryItem[]
     */
    protected array $summaryItem = array();

    public static function from(Summary $summary): SummaryResponse
    {
        $summaryResponse = new SummaryResponse();
        $summaryResponse->setTotalPoints($summary->getTotalPoints());

        foreach ($summary->getSummaryItems() as $item) {

        }

        return $summaryResponse;
    }

    public function addSummaryItem(SummaryItemResponse $summaryItemResponse)
    {
        $this->summaryItem[] = $summaryItemResponse;
    }

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @param int $totalPoints
     */
    public function setTotalPoints(int $totalPoints): void
    {
        $this->totalPoints = $totalPoints;
    }

    /**
     * @return array
     */
    public function getSummaryItem(): array
    {
        return $this->summaryItem;
    }

    /**
     * @param array $summaryItem
     */
    public function setSummaryItem(array $summaryItem): void
    {
        $this->summaryItem = $summaryItem;
    }
}
