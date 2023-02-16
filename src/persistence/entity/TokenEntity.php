<?php

namespace Nils\QuizTee\persistence\entity;

use Doctrine\ORM\Mapping as ORM;
use Nils\QuizTee\persistence\repository\TokenRepository;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Table(name: 'token')]
class TokenEntity extends BaseEntity
{
    #[ORM\Column(type: 'string', unique: true)]
    protected string $jwt;

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return $this->jwt;
    }

    /**
     * @param string $jwt
     */
    public function setJwt(string $jwt): void
    {
        $this->jwt = $jwt;
    }
}
