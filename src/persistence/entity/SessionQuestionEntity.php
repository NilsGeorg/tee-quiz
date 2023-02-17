<?php

namespace Nils\QuizTee\persistence\entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nils\QuizTee\persistence\repository\SessionQuestionRepository;

#[ORM\Entity(repositoryClass: SessionQuestionRepository::class)]
#[ORM\Table(name: 'session_question')]
class SessionQuestionEntity extends BaseEntity
{
    #[ORM\Column(type: 'boolean')]
    private bool $answered = false;

    #[ORM\ManyToOne(targetEntity: QuestionEntity::class)]
    private QuestionEntity $question;

    #[ORM\JoinTable(name: 'session_answers')]
    #[ORM\JoinColumn(referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: AnswerEntity::class)]
    private Collection $answers;

    #[ORM\ManyToOne(targetEntity: SessionEntity::class)]
    private SessionEntity $session;

    /**
     * @return bool
     */
    public function isAnswered(): bool
    {
        return $this->answered;
    }

    /**
     * @param bool $answered
     */
    public function setAnswered(bool $answered): void
    {
        $this->answered = $answered;
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

    /**
     * @return SessionEntity
     */
    public function getSession(): SessionEntity
    {
        return $this->session;
    }

    /**
     * @param SessionEntity $session
     */
    public function setSession(SessionEntity $session): void
    {
        $this->session = $session;
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
