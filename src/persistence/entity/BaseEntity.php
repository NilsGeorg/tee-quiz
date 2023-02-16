<?php

namespace Nils\QuizTee\persistence\entity;


class BaseEntity
{
    // TODO: replace with uuid object - Hibernate Default UUID?
    protected string $id;

    public function __construct()
    {
        $this->id = uniqid();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}