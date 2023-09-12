<?php

declare(strict_types=1);

namespace App\Services;

class EmailService
{
    /**
     * EmailService constructor.
     */
    public function __construct()
    {
    }

    public function send(array $customer, string $string): bool
    {
        return true;
    }
}
