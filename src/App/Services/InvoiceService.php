<?php

//declare(strict_types=1);

namespace App\Services;

class InvoiceService
{
    public function __construct(
        protected SaleTaxService $salesTaxService,
        protected PaymentGatewayInterface $gatewayService,
        protected EmailService $emailService
    ) {
    }

    public function process(array $customer, float $amount): bool
    {
        echo "Invoice is processing  <br>";
        $tax = $this->salesTaxService->calculate($amount, $customer);

        if (! $this->gatewayService->charge($customer, $amount, $tax)) {
            return false;
        }

        return true;
    }
}
