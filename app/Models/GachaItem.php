<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GachaItem extends Model
{
    use HasFactory;

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
        'star_coin_reward',
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
     * Acessor para gerar a URL pública da imagem (versão compatível com pasta dentro de public/).
     */
    public function getImagemUrlAttribute()
    {
        if ($this->imagem) {
            $filename = basename($this->imagem);
            return asset('storage/gacha_images/' . $filename);
        }
        return null;
    }
}
