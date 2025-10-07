<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GachaItem extends Model
{
    use HasFactory;

    // Nome correto da tabela
    protected $table = 'table_gacha_items';

    protected $fillable = [
        'nome',
        'titulo',
        'imagem',
        'tipo',
        'raridade',
        'descricao',
        'passivas',
        'habilidades',
        'status',
        'taxa_drop',
    ];

    protected $casts = [
        'passivas' => 'array',
        'habilidades' => 'array',
        'status' => 'boolean',
    ];

    protected $appends = ['imagem_url'];

    /**
     * Relação inversa com os banners exclusivos.
     */
    public function bannersExclusivos()
    {
        return $this->belongsToMany(
            BannerBox::class, 
            'banner_exclusive_items', 
            'item_id', 
            'banner_id'
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
