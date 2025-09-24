<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'token',
    ];

    /**
     * Relationship dengan Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get token by store ID
     */
    public static function getTokenByStore($storeId): ?string
    {
        $storeToken = self::where('store_id', $storeId)->first();
        return $storeToken ? $storeToken->token : null;
    }

    /**
     * Get store by token
     */
    public static function getStoreByToken($token): ?Store
    {
        $storeToken = self::where('token', $token)->first();
        return $storeToken ? $storeToken->store : null;
    }
}
