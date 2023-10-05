<?php

namespace App\Controllers;

use App\Attributes\Route;
use App\DBDoctrine;
use App\Services\InvoiceService;
use App\View;
use App\Models;

class Home
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }
    #[Route("/")]
    public function index(): string
    {
        $this->invoiceService->process([], 23);
        return View::make('index');
    }
}
