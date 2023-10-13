<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "./vendor/autoload.php";


$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/src/.env');

$params = [
    'host' => $_ENV['HOST'],
    'username' => $_ENV['DB_USER'],
    'database' => $_ENV['DB_NAME'],
    'password' => $_ENV['DB_PASS'],
    'driver' => 'mysql',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];

$capsule = new Capsule();
$capsule->addConnection($params);
$capsule->setEventDispatcher(new Dispatcher(new Container()));
$capsule->setAsGlobal();
$capsule->bootEloquent();
