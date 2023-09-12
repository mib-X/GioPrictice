<?php

declare(strict_types=1);

namespace App\Services;

class SaleTaxService
{

    public function __construct()
    {
    }

    public function calculate(float $amount, array $customer): float
    {
        return $amount * 6.5 / 100;
    }


}