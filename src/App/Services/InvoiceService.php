<?php

//declare(strict_types=1);

namespace App\Services;

class InvoiceService
{
    public function __construct(
        protected SaleTaxService $salesTaxService,
        protected PaymentGatewayService $gatewayService,
        protected EmailService $emailService
    ) {
    }

    public function process(array $customer, float $amount): bool
    {
        echo "Invoice is processing";
        $tax = $this->salesTaxService->calculate($amount, $customer);

        if (! $this->gatewayService->charge($customer, $amount, $tax)) {
            return false;
        }

        $this->emailService->send($customer, 'receipt');

        return true;
    }
}