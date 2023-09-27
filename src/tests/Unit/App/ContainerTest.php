<?php

namespace Tests\Unit\App;

use App\Container;
use App\Controllers\Home;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testGetDependencyWhenDependencyExists()
    {
        $dependencyMock = $this->createMock(Home::class);
        $this->container->set("dependency", function () use ($dependencyMock) {
            return $dependencyMock;
        });
        $result = $this->container->get('dependency');
        $this->assertInstanceOf(Home::class, $result);
    }
    public function testGetDependencyWhenDependencyDoesNotExists()
    {
        $dependencyMock = $this->createMock(Home::class);
        $this->container->set("dependency", function () use ($dependencyMock) {
            return $dependencyMock;
        });
        $this->expectException(ContainerException::class);
        $result = $this->container->get('not_exists_dependency');
    }
    public function testResolveDependencyWhenDependencyDoesNotExistsButClassIsInstantiable()
    {
        $dependency = new class ()
        {
            public function hello()
            {
                return 'hello';
            }
        };
        $result = $this->container->resolve($dependency::class);
        $this->assertInstanceOf($dependency::class, $result);
        $this->assertEquals('hello', $result->hello());
    }

    public function testSetDependency()
    {
        $this->container->set("dependency", fn() => new Dependency());
        $this->assertTrue($this->container->has('dependency'));
    }
    public function testHasMethodReturnsTrueDependencyWhenDependencyExists()
    {
        $this->container->set("dependency", fn() => new Dependency());

        $this->assertTrue($this->container->has('dependency'));
    }
    public function testHasMethodReturnsFalseDependencyWhenDependencyDoesNotExists()
    {
        $this->assertFalse($this->container->has('dependency'));
    }
}
