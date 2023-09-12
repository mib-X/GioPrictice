<?php

declare(strict_types=1);

namespace App\Services;

class PaymentGatewayService
{

    /**
     * PaymentGatewayService constructor.
     */
    public function __construct()
    {
    }

    public function charge(array $customer, float $amount, float $tax): bool
    {
        return (bool) mt_rand(0, 1);
    }
}
