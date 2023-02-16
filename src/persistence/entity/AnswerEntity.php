<?php

namespace Nils\QuizTee\persistence\entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'answer')]
#[ORM\UniqueConstraint(columns: ['question_id', 'orderIndex'])]
class AnswerEntity extends BaseEntity
{
    #[ORM\Column(type: 'string')]
    private string $answer;
    #[ORM\Column(type: 'boolean')]
    private bool $isCorrect;
    #[ORM\Column(type: 'integer')]
    private int $orderIndex;

    #[ORM\ManyToOne(targetEntity: QuestionEntity::class, inversedBy: 'answers')]
    private QuestionEntity $question;

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

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * @param int $orderIndex
     */
    public function setOrderIndex(int $orderIndex): void
    {
        $this->orderIndex = $orderIndex;
    }

    /**
     * @return QuestionEntity
     */
    public function getQuestion(): QuestionEntity
    {
        return $this->question;
    }

    /**
     * @param QuestionEntity $question
     */
    public function setQuestion(QuestionEntity $question): void
    {
        $this->question = $question;
    }
}
