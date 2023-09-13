<?php

declare(strict_types=1);

namespace Tests\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayInterface;
use App\Services\SaleTaxService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /**@Test**/
    public function testProcessInvoice(): void
    {
        //givcn invoice service
        $salesTaxServiceMock = $this->createMock(SaleTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayInterface::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $gatewayServiceMock->method('charge')->willReturn(true);

        $customer = ['name' => 'mib-x', 'email' => 'mibX@ukr.net'];
        $amount = 250;

        //when process is called

        $result = $invoiceService->process($customer, $amount);

        //then assert than invoice service return true

        $this->assertTrue($result);
    }

    public function testSendEmailWhenInvoiceIsProcessing(): void
    {
        //givcn invoice service
        $salesTaxServiceMock = $this->createMock(SaleTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayInterface::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $emailServiceMock->expects($this->once())
            ->method('send')
            ->with(
                ['name' => 'mib-X', 'email' => 'mibX@ukr.net'],
                'receipt'
            );
        $gatewayServiceMock->method('charge')->willReturn(true);

        $customer = ['name' => 'mib-X', 'email' => 'mibX@ukr.net'];
        $amount = 250;
        //when process is called

        $result = $invoiceService->process($customer, $amount);

        //then assert than invoice service return true

        $this->assertTrue($result);
    }
}
