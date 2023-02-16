<?php

namespace Nils\QuizTee\persistence\repository;

use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\persistence\entity\SessionEntity;
use Nils\QuizTee\persistence\entity\SessionQuestionEntity;

class SessionQuestionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(SessionQuestionEntity::class);
    }

    public function create(QuestionEntity $questionEntity, SessionEntity $sessionEntity): SessionQuestionEntity
    {
        $questionEntity = $this->getEntityManager()->find(QuestionEntity::class, $questionEntity->getId());
        $sessionEntity = $this->getEntityManager()->find(SessionEntity::class, $sessionEntity->getId());

        $question = new SessionQuestionEntity();
        $question->setQuestion($questionEntity);
        $question->setSessionEntity($sessionEntity);

        $this->getEntityManager()->persist($question);
        $this->getEntityManager()->flush();

        return $question;
    }
}
