<?php

namespace App\Controllers;

use App\App;
use App\Container;
use App\Services\InvoiceService;
use App\View;
use App\Models;

class Home
{
    public function index(): string
    {
        (new Container())->get(InvoiceService::class)->process([], 23);
        return View::make('index')->render();
    }
}
