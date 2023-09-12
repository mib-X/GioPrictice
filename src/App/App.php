<?php

namespace App;

use App\Exceptions\RouterNotFoundException;

class App
{
    private static DB $db;

    public function __construct(protected Router $router, protected array $request, protected array $config)
    {
        static::$db = new DB($config);
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
