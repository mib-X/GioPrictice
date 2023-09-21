<?php

declare(strict_types=1);

namespace App\Enums;

class EmailStatus
{
    public const QUEUE = 0;
    public const SENT = 1;
    public const FAILED = 2;

    public function all()
    {
        return [
            self::QUEUE,
            self::SENT,
            self::FAILED
        ];
    }
}
