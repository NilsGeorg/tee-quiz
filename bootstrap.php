<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . "/src"),
    isDevMode: true,
);
// or if you prefer annotation, YAML or XML
// $config = ORMSetup::createAnnotationMetadataConfiguration(
//    paths: array(__DIR__."/src"),
//    isDevMode: true,
// );
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: array(__DIR__."/config/xml"),
//    isDevMode: true,
//);
// $config = ORMSetup::createYAMLMetadataConfiguration(
//    paths: array(__DIR__."/config/yaml"),
//    isDevMode: true,
// );

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
