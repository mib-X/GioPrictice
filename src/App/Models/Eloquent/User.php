<?php

declare(strict_types=1);

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string email
 *    @property string full_name
 *    @property int is_active
 *    @property \DateTime created_at
*/
class User extends \Illuminate\Database\Eloquent\Model
{
    public const UPDATED_AT = null;
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
