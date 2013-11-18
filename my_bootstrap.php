<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("./module/Application/src/Application/Model/Entity");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
<<<<<<< HEAD
    'dbname'   => 'tuto',
=======
    'dbname'   => 'zscdb',
>>>>>>> 72f5a3596c62e0713ea8ac07feca2eee7460d309
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
