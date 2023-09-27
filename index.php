<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Container;
use App\Controllers;
use App\Router;
use App\App;
use Symfony\Component\Dotenv\Dotenv;

require_once "./vendor/autoload.php";

const VIEW_PATH = __DIR__ . "/src/App/views";

$config = include __DIR__ . "/src/App/config/config.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/src/.env');
$container = new Container();
$router = new Router($container);

$router->registerRouterFromControllerAttributes([
    Controllers\Home::class,
    Controllers\GeneratorController::class,
    Controllers\InvoiceController::class,
    Controllers\UserController::class
]) ;

//$router
//    ->get("/", [Controllers\Home::class, "index"])
//    ->get("/invoice", [Controllers\InvoiceController::class, "index"])
//    ->get("/invoice/create", [Controllers\InvoiceController::class, "create"])
//    ->post("/invoice/create", [Controllers\InvoiceController::class, "shop"])
//    ->get("/generator", [Controllers\GeneratorController::class, "index"])
//;

(new App(
    $container,
    $router,
    ["uri" => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->init()->run();
