<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
        'titulo_alternativo', 
        'nota', 
        'popularidade', 
        'generos',
        'autor', 
        'estudio', 
        'ano_lancamento', 
        'episodios', 
        'rank',
        'descricao', 
        'cover_image', 
        'categoria_imagem'
    ];
    

    protected $casts = [
        'ano_lancamento' => 'integer',
    ];
}