<?php

namespace Nils\QuizTee\persistence\repository;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\ORMSetup;

class AbstractRepository extends EntityRepository
{
    public function __construct(string $className)
    {
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/src"),
            isDevMode: true,
        );

        // TODO: Move secrets to config file
        // configuring the database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'dbname' => 'tee-quiz',
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'quizzer',
            'password' => 'QUIZ123',
        ], $config);

        // obtaining the entity manager
        $entityManager = new EntityManager($connection, $config);

        parent::__construct($entityManager, new ClassMetadata($className));
    }
}
