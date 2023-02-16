<?php

namespace Nils\QuizTee\persistence\repository;

use Nils\QuizTee\persistence\entity\QuestionEntity;
use Ramsey\Uuid\Uuid;

class QuestionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(QuestionEntity::class);
    }

    protected string $className = QuestionEntity::class;

    public function findFirst(): QuestionEntity
    {
        return $this->findOneBy(['orderIndex' => '1']);
    }

    public function findAll(): array
    {
        return $this->findBy([], ['orderIndex' => 'ASC']);
    }

    public function findById(Uuid $id): ?QuestionEntity
    {
        return $this->find($id);
    }

    public function findNext(int $current): ?QuestionEntity
    {
        return $this->findOneBy(['queryIndex' => $current + 1]);
    }
}
