<?php

namespace Nils\QuizTee\persistence\entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nils\QuizTee\persistence\repository\QuestionRepository;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'question')]
class QuestionEntity extends BaseEntity
{
    #[ORM\Column(type: 'string')]
    private string $question;

    #[ORM\Column(type: 'integer', unique: true)]
    private int $orderIndex;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: AnswerEntity::class)]
    private Collection $answers;

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
     * @return Collection
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    /**
     * @param Collection $answers
     */
    public function setAnswers(Collection $answers): void
    {
        $this->answers = $answers;
    }
}
