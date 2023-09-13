<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];
            if (is_callable($entry)) {
                return $entry($this);
            }
            $id = $entry;
        }
        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {

        //1.Изучаем класс, который хотим получить из контейнера
        $reflectionClass = new ReflectionClass($id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException();
        }

        //2. Получаем его __constructor

        $constuctor = $reflectionClass->getConstructor();

        if ($constuctor == null) {
            return $reflectionClass->newInstance();
        }

        //3. Изучаем параметры конструктора(возможные зависимости)

        $parameters = $constuctor->getParameters();

        if (! $parameters) {
            return $reflectionClass->newInstance();
        }

        //4. Если пераметры конструктора тоже классы, то пытаемся применить функцию к нему в рекурсии
        $dependencies = array_map(function (\ReflectionParameter $parameter) use ($id) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (! $type) {
                throw new ContainerException("Failed to resolve class $id because param $name is missing a type hint");
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }
            throw new ContainerException("Failed to resolve class" . $id);
        }, $parameters);
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
