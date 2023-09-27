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
    protected Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = []

    ) {
    }
    public function init(): self
    {
        $this->config = new Config($_ENV);
        static::$db = new DB($this->config->db);
        $this->container->set(PaymentGatewayInterface::class, PaddlePayment::class);
        $this->container->set(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));
        return $this;
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
