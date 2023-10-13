<?php

namespace App\Controllers;

use App\Attributes\Route;
use App\Enums\InvoiceStatus;
use App\Models\Eloquent\Invoice;
use App\Services\InvoiceService;
use App\View;

class Home
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }
    #[Route("/")]
    public function index(): string
    {
        $this->invoiceService->process([], 23);
        $data['invoices'] = Invoice::query()
        ->join('users', 'users.id', '=', 'user_id')
            ->select('invoices.id', 'full_name', 'amount', 'email', 'status')
        ->get()->toArray();

        foreach ($data['invoices'] as &$invoice) {
            $invoice['status'] = InvoiceStatus::getName((int) $invoice['status']);
        }
        return View::make('index', $data);
    }
}
