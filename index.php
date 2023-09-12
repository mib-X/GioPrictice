<?php

use App\Container;
use App\Controllers;
use App\Router;
use App\App;

require_once "./vendor/autoload.php";

define("VIEW_PATH", __DIR__ . "/src/App/views");

$config = include __DIR__ . "/src/App/config/config.php";
$container = new Container();
$router = new Router($container);


$router
    ->get("/", [Controllers\Home::class, "index"])
    ->get("/invoice", [Controllers\Invoice::class, "index"])
    ->get("/invoice/create", [Controllers\Invoice::class, "create"])
    ->post("/invoice/create", [Controllers\Invoice::class, "shop"])
;

(new App($router, ["uri" => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']], $config))->run();