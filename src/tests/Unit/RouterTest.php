<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container;
use App\Exceptions\RouterNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
        $this->router = new Router($this->container);
    }
    public function testRegisterARoute()
    {
        $this->router->register('post', "/", ['User','index']);
        $expected = ['post' => ['/' =>  ['User','index']]];
        $this->assertEquals($expected, $this->router->routes());
    }
    public function testRegisterAGetRoute()
    {
        $this->router->get("/", ['User','index']);
        $expected = ['get' => ['/' =>  ['User','index']]];
        $this->assertEquals($expected, $this->router->routes());
    }
    public function testRegisterAPostRoute()
    {
        $this->router->post("/users", ['User','index']);
        $expected = ['post' => ['/users' =>  ['User','index']]];
        $this->assertEquals($expected, $this->router->routes());
    }
    public function testNoRoutesRegistered()
    {
        $emptyRouter = new Router($this->container);
        $this->assertEmpty($emptyRouter->routes());
    }
    /**
     * @dataProvider Tests\Unit\DataProviders\RouterDataProvider::routerNotFoundCases
     **/
    public function testThrowsRouterNotFoundException(
        string $requestUri,
        string $requestMethod
    ) {
        $users = new class () {
            public function delete(): bool
            {
                return true;
            }
        };
        $this->router->get("/users", [$users::class , 'index']);
        $this->router->post("/users", ['Users' , 'shop']);
        $this->router->register('put', "/users", [$users::class , 'delete']);
        $this->expectException(RouterNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }
    public function testResolveFromClosure()
    {
        $this->router->get("/users", fn() => [1, 2, 3]);
        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', 'get')
        );
    }
    public function testResolveRoute()
    {
        $users = new class () {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };
        $this->router->get('/users', [$users::class, 'index']);
        $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'get'));
    }
}
