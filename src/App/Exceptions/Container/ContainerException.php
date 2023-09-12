<?php

namespace App\Exceptions\Container;

use Psr\Container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    public function __construct()
    {
    }
}
