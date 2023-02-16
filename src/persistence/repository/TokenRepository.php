<?php

namespace Nils\QuizTee\persistence\repository;

use Nils\QuizTee\persistence\entity\TokenEntity;

class TokenRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(TokenEntity::class);
    }

    public function findByJwt(string $jwt): ?TokenEntity
    {
        return $this->findOneBy(['token' => $jwt]);
    }

    public function create(string $jwt): TokenEntity
    {
        $token = new TokenEntity();
        $token->setJwt($jwt);

        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();

        return $token;
    }
}
