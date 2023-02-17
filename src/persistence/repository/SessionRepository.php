<?php

namespace Nils\QuizTee\persistence\repository;

use Nils\QuizTee\persistence\entity\SessionEntity;
use Nils\QuizTee\persistence\entity\TokenEntity;

class SessionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(SessionEntity::class);
    }

    public function create(TokenEntity $tokenEntity): SessionEntity
    {
        $tokenEntity = $this->getEntityManager()->find(TokenEntity::class, $tokenEntity->getId());

        $session = new SessionEntity();
        $session->setToken($tokenEntity);

        $this->getEntityManager()->persist($session);
        $this->getEntityManager()->flush();

        return $session;
    }

    public function close(SessionEntity $sessionEntity): SessionEntity
    {
        /**
         * @var $sessionEntity SessionEntity
         */
        $sessionEntity = $this->find($sessionEntity->getId());
        $sessionEntity->setFinished(true);

        $this->getEntityManager()->flush();

        return $sessionEntity;
    }
}
