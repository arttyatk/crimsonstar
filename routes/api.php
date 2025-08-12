<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DueloController;
use App\Http\Controllers\GeraTokenController;

// Rotas públicas (sem autenticação)
Route::post('/login', [GeraTokenController::class, 'gera']);
Route::post('/registrar', [GeraTokenController::class, 'registrauser']);
Route::get('/dashboard/stats', [AnimeController::class, 'dashboardStats']);
Route::get('/dashboard/genre-distribution', [AnimeController::class, 'genreDistribution']);
Route::get('/dashboard/monthly-activity', [AnimeController::class, 'monthlyActivity']);
// Rotas protegidas (requer token de login com Sanctum)
Route::middleware(['auth:sanctum', Cors::class])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getuser', [AnimeController::class, 'getUserInfo']);

    // Rotas CRUD padrão
    Route::get('/animes', [AnimeController::class, 'index']);
    Route::post('/animes', [AnimeController::class, 'store']);  
    Route::get('/animes/{id}', [AnimeController::class, 'show']);
    Route::put('/animes/{id}', [AnimeController::class, 'update']);
    Route::delete('/animes/{id}', [AnimeController::class, 'destroy']);
    Route::get('/gerapdf/criar/{id}', [AnimeController::class, 'gerapdf']);

    // Rotas de teste para filtros (protegidas também)
    Route::prefix('test')->group(function () {
        Route::get('/genero/{genero}', function ($genero) {
            return app()->make(AnimeController::class)->index(
                new Request(['genero' => $genero])
            );
        });

        Route::get('/nota-minima/{nota}', function ($nota) {
            return app()->make(AnimeController::class)->index(
                new Request(['nota_min' => $nota])
            );
        });

        Route::get('/animes/popularidade', [AnimeController::class, 'getAnimesByPopularity']);

        Route::get('/ordenar/{campo}/{direcao?}', function ($campo, $direcao = 'asc') {
            return app()->make(AnimeController::class)->index(
                new Request([
                    'ordenar_por' => $campo,
                    'ordenar_direcao' => $direcao
                ])
            );
        });

        Route::get('/combinado', function () {
            return app()->make(AnimeController::class)->index(
                new Request([
                    'genero' => 'Ação',
                    'nota_min' => 8,
                    'popularidade_min' => 70,
                    'ordenar_por' => 'nota',
                    'ordenar_direcao' => 'desc'
                ])
            );
        });
    });

});