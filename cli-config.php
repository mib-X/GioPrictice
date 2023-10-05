<?php


use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Dotenv\Dotenv;

require_once "./vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/src/.env');

$params = ['host' => $_ENV['HOST'],
    'user' => $_ENV['DB_USER'],
    'dbname' => $_ENV['DB_NAME'],
    'password' => $_ENV['DB_PASS'],
    'driver' => 'pdo_mysql'
];

try {
    $connection = DriverManager::getConnection($params);
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $entityManager = new EntityManager(
        $connection,
        ORMSetup::createAttributeMetadataConfiguration([__DIR__ . "/src/App/Entity"])
    );
} catch (MissingMappingDriverImplementation $e) {
    echo $e->getMessage();
}

$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders

//$paths = [__DIR__.'/src/App/Entity'];
//$isDevMode = true;
//
//$ORMconfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
//$entityManager = EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true], $ORMconfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
