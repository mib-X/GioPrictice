<?php

namespace App;

use App\Exceptions\RouterNotFoundException;
use App\Services\CustomMailer;
use App\Services\PaddlePayment;
use App\Services\PaymentGatewayInterface;
use App\Services\StripePayment;
use Symfony\Component\Mailer\MailerInterface;

class App
{
    private static DB $db;

    public function __construct(
        Container $container,
        protected Router $router,
        protected array $request,
        protected array $config
    ) {
        static::$db = new DB($config);
        $container->set(PaymentGatewayInterface::class, PaddlePayment::class);
        $container->set(MailerInterface::class, fn() => new CustomMailer($_ENV['MAILER_DSN']));
    }
    public static function getDB(): DB
    {
        return static::$db;
    }
    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouterNotFoundException $e) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }
}
