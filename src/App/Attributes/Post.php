<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute]
class Post extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath);
        $this->method = 'post';
    }
}