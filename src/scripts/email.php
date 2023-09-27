<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Container;
use App\Controllers;
use App\Router;
use App\App;
use App\Services\CustomMailer;
use App\Services\EmailService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Mailer\MailerInterface;

require_once "../../vendor/autoload.php";

const VIEW_PATH = "../App/views";
$config = include "../App/config/config.php";

$dotenv = new Dotenv();
$dotenv->load('../.env');
$container = new Container();


(new App($container))->init();

try {
    $container->get(EmailService::class)->sendQueuedEmails();
} catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
    echo $e->getMessage();
}
