<?php

namespace App\Services;

class StripePayment implements PaymentGatewayInterface
{
    public function charge(array $customer, float $amount, float $tax): bool
    {
        echo "Charging from Stripe <br>";
        return (bool) mt_rand(0, 1);
    }
}
