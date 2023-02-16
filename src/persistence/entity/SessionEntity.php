<?php

namespace Nils\QuizTee\persistence\entity;


use Doctrine\ORM\Mapping as ORM;
use Nils\QuizTee\persistence\repository\SessionRepository;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table(name: 'session')]
class SessionEntity extends BaseEntity
{
    #[ORM\Column(type: 'boolean')]
    private bool $finished = false;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $started;

    #[ORM\ManyToOne(targetEntity: TokenEntity::class)]
    private TokenEntity $token;

    public function __construct()
    {
        $this->started = new \DateTime();
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }

    /**
     * @return \DateTime
     */
    public function getStarted(): \DateTime
    {
        return $this->started;
    }

    /**
     * @return TokenEntity
     */
    public function getToken(): TokenEntity
    {
        return $this->token;
    }

    /**
     * @param TokenEntity $token
     */
    public function setToken(TokenEntity $token): void
    {
        $this->token = $token;
    }
}
