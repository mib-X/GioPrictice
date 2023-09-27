<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Email;
use App\Models\Model;
use Symfony\Component\Mime\Address;

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
        echo "InvoiceController is processing  <br>";
        $tax = $this->salesTaxService->calculate($amount, $customer);

        if (! $this->gatewayService->charge($customer, $amount, $tax)) {
            return false;
        }

        $this->emailService->registerEmail($customer);

        return true;
    }
}
