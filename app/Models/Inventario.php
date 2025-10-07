<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    protected $fillable = [
        'user_id', 
        'gacha_item_id', 
        'quantidade'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function item() {
        return $this->belongsTo(GachaItem::class, 'gacha_item_id');
    }

    
}
