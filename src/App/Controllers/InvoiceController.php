<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\View;

class InvoiceController
{
    #[Get('/invoice')]
    public function index(): string
    {
        $invoices = (new Invoice())->all(InvoiceStatus::WAITING);
        foreach ($invoices as &$invoice) {
            $invoice['status'] = InvoiceStatus::getName((int) $invoice['status']);
        }

        return (new View('invoice/index', ['invoices' => $invoices]))->render();
    }
    #[Get('/invoice/create')]
    public function create(): string
    {
        return (new View('invoice/create'))->render();
    }
    #[Post('/invoice/create')]
    public function shop()
    {
        $data['amount'] = $_POST['amount'];
        return (new View('invoice/shop', $data))->render();
    }
}
