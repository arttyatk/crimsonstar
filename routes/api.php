<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DueloController;
use App\Http\Controllers\GeraTokenController;
use App\Http\Middleware\Api_Auth;
use App\Http\Controllers\GachaItemController;
use App\Http\Middleware\CheckUserToken;
use App\Http\Controllers\BannerBoxController;
use App\Http\Controllers\GachaController;
use App\Http\Controllers\PerfilController;

// Rotas públicas (sem autenticação)
Route::post('/login', [GeraTokenController::class, 'gera']);
Route::post('/registrar', [GeraTokenController::class, 'registrauser']);
Route::get('/dashboard/stats', [AnimeController::class, 'dashboardStats']);
Route::get('/dashboard/genre-distribution', [AnimeController::class, 'genreDistribution']);
Route::get('/dashboard/monthly-activity', [AnimeController::class, 'monthlyActivity']);
Route::post('/atribuir-exclusivo', [GachaItemController::class, 'atribuirExclusivo']);
 // Rota para buscar os dados do perfil do usuário autenticado


Route::get('/profile/{id}', [PerfilController::class, 'getById']); 


Route::get('/retorna_itens', [GachaItemController::class, 'retorna_itens']);

Route::middleware([CheckUserToken::class, Cors::class])->group(function () {
Route::apiResource('gacha-items', GachaItemController::class);
Route::get('/profile', [PerfilController::class, 'show']);
    Route::get('/profile/{id?}', [PerfilController::class, 'show']);
    Route::put('/profile/{id?}', [PerfilController::class, 'update']);
    Route::post('/gacha/spin/{banner}', [GachaController::class, 'spin']);
    Route::get('/inventario/{userId}', [GachaController::class, 'show']);
});

Route::get('/teste', function() {
    return response()->json(['message' => 'Rota de teste funcionando!']);
});



Route::controller(BannerBoxController::class)->group(function () {
    Route::get('/banners-boxes', 'index');
    Route::post('/banners-boxes', 'store');
    Route::get('/banners-boxes/{id}', 'show');
    Route::put('/banners-boxes/{id}', 'update');
    Route::delete('/banners-boxes/{id}', 'destroy');
});


// Rotas protegidas (requer token de login com Sanctum)
Route::middleware(['auth:sanctum', Cors::class])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getuser', [AnimeController::class, 'getUserInfo']);

    // Rotas CRUD padrão
    Route::get('/gerapdf/criar/{id}', [AnimeController::class, 'gerapdf']);

});