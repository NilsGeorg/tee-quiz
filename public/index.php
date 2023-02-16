<?php

include './../vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;

require_once 'routes.php';
require_once 'helpers.php';

\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

// Start the routing
SimpleRouter::start();
