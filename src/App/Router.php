<?php

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Exceptions\RouterNotFoundException;

class Router
{
    public function __construct(private Container $container)
    {
    }

    private array $routes = [];
    public function registerRouterFromControllerAttributes(array $controllers)
    {
        foreach ($controllers as $controller) {
            $rClass = new \ReflectionClass($controller);

            foreach ($rClass->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }
    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }
    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }
    public function routes(): array
    {
        return $this->routes;
    }
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode("?", $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;
        if (! $action) {
            throw new RouterNotFoundException();
        }
        if (is_callable($action)) {
            return call_user_func($action);
        }
        [$class, $method] = $action;
        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }
        throw new RouterNotFoundException();
    }
}
