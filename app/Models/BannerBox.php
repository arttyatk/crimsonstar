<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class BannerBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'tipo',
        'imagem',
        'itens_ids',
        'status',
    ];

    // Inclui o atributo virtual 'imagem_url' na resposta JSON
    protected $appends = ['imagem_url'];

    /**
     * Relação com os itens exclusivos do banner.
     * Inclui 'taxa_drop' da pivot.
     */
    public function exclusivos()
    {
        return $this->belongsToMany(
            GachaItem::class, 
            'banner_exclusive_items', 
            'banner_id', 
            'item_id'
        )->withPivot('taxa_drop')->withTimestamps();
    }

    /**
     * Acessor para gerar a URL pública da imagem.
     */
    public function getImagemUrlAttribute()
    {
        if ($this->imagem && Storage::disk('public')->exists($this->imagem)) {
            return asset(Storage::url($this->imagem));
        }
        return null;
    }
}
