<?php

namespace Tests\Unit\DataProviders;

class RouterDataProvider
{
    public function routerNotFoundCases(): array
    {
        return [
            ['/users', 'delete'], //method delete does not exist
            ['/invoices', 'get' ], //uri /invoices does not exist
            ['/users' , 'get'], //class_method index of $users::class doesn't exist
            ['/users', 'post'], //class Users doesn't exist
            // ['/users' , 'put'],  //do not throw exception
        ];
    }
}
