<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use App\Enums\InvoiceStatus;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Invoice;
use App\Models\UserEloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once "../../vendor/autoload.php";
require_once "../../eloquent.php";

//$invoices = Invoice::query()->where('amount', '>', '400');
//foreach ($invoices->cursor() as $invoice) {
//    echo $invoice['id'] . " - " . $invoice['amount'] . " - " . InvoiceStatus::getName($invoice['status']) .
//        " - " . $invoice['user']->full_name . PHP_EOL;
//}
//
//$invoiceUsers = UserEloquent::query()->where('id', '=', 1)->get();
//foreach ($invoiceUsers as $invoiceUser) {
//    echo  $invoiceUser['full_name'] . PHP_EOL;
//    foreach ($invoiceUser['invoices'] as $invoiceU) {
//        echo $invoiceU['id'] . " - " . $invoiceU['amount'] . " - " . InvoiceStatus::getName($invoiceU['status'])
//            .  PHP_EOL;
//    }
//}
//
//$user = UserEloquent::query()->insert([
//    'email' => 'mibx@ukr.net',
//    'full_name' => 'Mike Cooper',
//    'is_active' => true,
//    'created_at' => new DateTime()
//    ]);

//$user = User::find(1);
//$invoices = Invoice::whereBelongsTo($user);
//foreach ($invoices->cursor() as $invoice) {
//    echo $invoice['id'] . " - " . $invoice['amount'] . " - " . InvoiceStatus::getName($invoice['status']) .
//        " - " . $invoice['user']->full_name . PHP_EOL;
//}
\Illuminate\Database\Capsule\Manager::connection()->transaction(
    function () {
        $user = new User();
        $user->email = 'mibX@gmail.com';
        $user->full_name = 'Mikel Cooper';
        $user->is_active = false;
        $user->created_at = new DateTime();
        $user->save();

        $invoice = new Invoice();
        $invoice->amount = 135;
        $invoice->status = InvoiceStatus::WAITING;
        $invoice->user()->associate($user);

        $invoice->save();
    }
);
