<?php

namespace Nils\QuizTee\persistence\repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\ResultSetMapping;
use Nils\QuizTee\persistence\entity\AnswerEntity;
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
        $question->setSession($sessionEntity);

        $this->getEntityManager()->persist($question);
        $this->getEntityManager()->flush();

        return $question;
    }

    public function addAnswer(SessionQuestionEntity $sessionQuestion, Collection $answers)
    {
        $answers = $answers->map(function (AnswerEntity $answer) {
            return $this->getEntityManager()->find(AnswerEntity::class, $answer->getId());
        });

        /**
         * @var $sessionQuestion SessionQuestionEntity
         */
        $sessionQuestion = $this->find($sessionQuestion->getId());
        $sessionQuestion->setAnswers($answers);
        $sessionQuestion->setAnswered(true);

        $this->getEntityManager()->flush();
    }

    public function findHighestPositionBySession(SessionEntity $sessionEntity)
    {
        $rsm = new ResultSetMapping();
        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT MAX(q.orderIndex) FROM session_question sq ' .
                ' JOIN question q on q.id = sq.question_id WHERE session_id = ?', $rsm);
        $query->setParameter(1, $sessionEntity->getId());

        return $query->getScalarResult();
    }
}
