<?php

namespace App;

use App\Exceptions\RouterNotFoundException;
use App\Services\CustomMailer;
use App\Services\PaddlePayment;
use App\Services\PaymentGatewayInterface;
use App\Services\StripePayment;
use Symfony\Component\Mailer\MailerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

class App
{
    private static DBDoctrine $DBDoctrine;
    protected Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = []

    ) {
    }
    private function dbEloquentInit(array $params)
    {
        $capsule = new Capsule();
        $capsule->addConnection($params);
        $capsule->setEventDispatcher(new Dispatcher());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
    public function init(): self
    {
        $this->config = new Config($_ENV);
        static::$DBDoctrine = new DBDoctrine($this->config);
        $this->dbEloquentInit($this->config->dbEloquent);
        $this->container->set(PaymentGatewayInterface::class, PaddlePayment::class);
        $this->container->set(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));
        return $this;
    }
    public static function getDB(): DBDoctrine
    {
        return static::$DBDoctrine;
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
