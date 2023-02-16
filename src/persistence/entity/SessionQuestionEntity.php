<?php

namespace Nils\QuizTee\persistence\entity;

use Doctrine\ORM\Mapping as ORM;
use Nils\QuizTee\persistence\repository\SessionQuestionRepository;

#[ORM\Entity(repositoryClass: SessionQuestionRepository::class)]
#[ORM\Table(name: 'session_question')]
class SessionQuestionEntity extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: QuestionEntity::class)]
    private QuestionEntity $question;

    #[ORM\ManyToOne(targetEntity: AnswerEntity::class)]
    private ?AnswerEntity $answer;

    #[ORM\ManyToOne(targetEntity: SessionEntity::class)]
    private SessionEntity $sessionEntity;

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
     * @return AnswerEntity|null
     */
    public function getAnswer(): ?AnswerEntity
    {
        return $this->answer;
    }

    /**
     * @param AnswerEntity|null $answer
     */
    public function setAnswer(?AnswerEntity $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return SessionEntity
     */
    public function getSessionEntity(): SessionEntity
    {
        return $this->sessionEntity;
    }

    /**
     * @param SessionEntity $sessionEntity
     */
    public function setSessionEntity(SessionEntity $sessionEntity): void
    {
        $this->sessionEntity = $sessionEntity;
    }
}
