<?php

namespace App\Exceptions;

class RouterNotFoundException extends \Exception
{
    protected $message = "Route not found";
}
