<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\View;

class Invoice
{
    #[Get('/invoice')]
    public function index(): string
    {
        return (new View('invoice/index'))->render();
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
