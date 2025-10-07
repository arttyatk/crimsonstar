<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserToken extends Model
{
    protected $table = "user_token";

    protected $fillable = [
        'token',
        'user_id',
        'valido_ate'
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
