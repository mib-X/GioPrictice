<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class Invoice
{
    public function index(): string
    {
        return (new View('invoice/index'))->render();
    }
    public function create(): string
    {
        return (new View('invoice/create'))->render();
    }
    public function shop()
    {
        $data['amount'] = $_POST['amount'];
        return (new View('invoice/shop', $data))->render();
    }
}
