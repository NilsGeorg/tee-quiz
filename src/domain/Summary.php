<?php

namespace Nils\QuizTee\domain;

class Summary
{
    private int $totalPoints = 0;

    /**
     * @var SummaryItem[]
     */
    private array $summaryItems = array();

    public function addSummaryItem(SummaryItem $summaryItems)
    {
        $this->summaryItems[] = $summaryItems;
        $this->totalPoints += $summaryItems->getPoints();
    }

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @return array
     */
    public function getSummaryItems(): array
    {
        return $this->summaryItems;
    }
}
