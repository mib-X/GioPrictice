<?php

declare(strict_types=1);

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float $amount
 * @property int $id
 * @property int $user_id
 * @property int $status
 * */
class Invoice extends Model
{
    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    protected $table = "invoices";
    protected $primaryKey = 'id';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
