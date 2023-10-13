<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float $amount
 * @property int $id
 * @property int $user_id
 * @property int $status
 * */
class InvoiceEloquent extends Model
{
    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    protected $table = "invoices";
    protected $primaryKey = 'id';
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserEloquent::class, 'user_id', 'id');
    }
}
