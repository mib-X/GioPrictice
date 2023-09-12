<?php

namespace App\Controllers;

use App\Services\InvoiceService;
use App\View;
use App\Models;

class Home
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(): string
    {
        $this->invoiceService->process([], 23);
        return View::make('index')->render();
    }
}
