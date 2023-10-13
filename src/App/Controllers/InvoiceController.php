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
        $invoices = (new Invoice())->all();
        foreach ($invoices as &$invoice) {
            $invoice['status'] = InvoiceStatus::getName((int) $invoice['status']);
        }

        return View::make('invoice/index', ['invoices' => $invoices]);
    }
    #[Get('/invoice/create')]
    public function create(): string
    {
        return View::make('invoice/create');
    }
    #[Post('/invoice/create')]
    public function shop()
    {
        $user_id = 1;
        $data['amount'] = htmlentities($_POST['amount'], ENT_QUOTES);
        $data['id'] = (new Invoice())->create((int) $data['amount'], (int)$user_id);
        return View::make('invoice/shop', $data);
    }
    #[Get('/invoice/find')]
    public function findInvoice()
    {
        return View::make('invoice/find');
    }
    #[Post('/invoice/find')]
    public function infoInvoice()
    {
        $id = htmlentities($_POST['id'], ENT_QUOTES);
        $data['invoices'] = (new Invoice())->find((int) $id);
        return View::make('invoice/infoInvoice', $data);
    }
}
