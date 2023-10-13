<?php

declare(strict_types=1);

namespace App\Enums;

class InvoiceStatus
{
    public const WAITING = 0;
    public const PAID = 1;
    public const FAILED = 2;

    public function all()
    {
        return [
            self::WAITING,
            self::PAID,
            self::FAILED
        ];
    }
    public static function getName(int $value): string
    {
        return match ($value) {
            self::WAITING => 'WAITING',
            self::PAID => 'PAID',
            self::FAILED => 'FAILED',
            default => 'Wrong status'
        };
    }
}
