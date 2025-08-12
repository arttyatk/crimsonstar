<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\GeraTokenController;
// Certifique-se de importar o controlador correto para logout, se necessário
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/dashboard', function () {
    return view('inicial');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de perfil do usuário
    // Mantenha estas rotas dentro do middleware 'auth' se forem para usuários logados
    Route::get('/perfil/editar', [AnimeController::class, 'editar'])->name('perfil.editar'); // Se você tiver um método 'editar' no AnimeController
    Route::post('/perfil/atualizar', [AnimeController::class, 'atualizar'])->name('perfil.atualizar');
    Route::delete('/perfil/excluir', [AnimeController::class, 'excluir'])->name('perfil.excluir');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Rotas de Animes e Catálogo (ajustadas e agrupadas sob o middleware 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/catalogo', [AnimeController::class, 'catalogo'])->name('catalogo'); // Nome alterado para 'catalogo'
    Route::get('/descricaoanime/{id}', [AnimeController::class, 'showlaravel'])->name('anime.show'); // Rota para detalhes do anime

    // Rota para adicionar animes (mostrar formulário)
    Route::get('/addanimes', function () {
        return view('addanimes');
    })->name('addanimes');

    // Rota para processar o cadastro de um novo anime via formulário HTML
    Route::post('/animes/store-from-form', [AnimeController::class, 'storeFromForm'])->name('anime.store-from-form');

    // Rotas para Editar e Atualizar Animes (FRONTEND com formulário)
    // A rota GET para exibir o formulário de edição
    Route::get('/animes/{id}/edit', [AnimeController::class, 'edit'])->name('anime.edit');
    // A rota PUT para processar a submissão do formulário de atualização
    Route::put('/animes/{id}', [AnimeController::class, 'updateFromForm'])->name('anime.updateFromForm'); // Nome do método na controller

    // Rota para Excluir Anime (via formulário HTML)
    Route::delete('/anime/{id}', [AnimeController::class, 'destroy'])->name('anime.destroy'); // Mantido seu nome original 'anime.destroy'

    // Rota da página inicial (se ela for diferente do dashboard e precisar de autenticação)
    Route::get('/inicio', function () {
        return view('inicial');
    })->name('inicio');

    // Suas rotas adicionais (se necessário e protegidas por autenticação)
    Route::get('/animeedit', function () {
        return view('animeedit'); // Verifique se esta rota ainda é necessária ou se será substituída por 'anime.edit'
    });

    Route::get('/animenota', function () {
        return view('animenota');
    });

    Route::get('/animepopularidade', function () {
        return view('animepopularidade');
    });

    Route::get('/animegenero', function () {
        return view('animegenero');
    });
});


// Rota para validação de e-mail (geralmente não precisa de autenticação)
Route::get('/valida_email/{codigo}', [GeraTokenController::class, 'validar_email']);

// As rotas de prefixo 'animes' que você tinha, se elas são para API,
// devem ser separadas ou renomeadas para evitar conflitos com as rotas de frontend.
// Se elas são para o frontend, as rotas acima já as substituem ou complementam.
// Vou comentar as suas rotas `prefix('animes')` porque as rotas que adicionei e corrigi
// já cobrem a funcionalidade de CRUD via formulário HTML que você pediu.
/*
Route::prefix('animes')->group(function() {
    // Exibir formulário de criação (já coberto por /addanimes e storeFromForm)
    // Route::get('/create', [AnimeController::class, 'create'])->name('animes.create');
    // Processar formulário de criação (já coberto por storeFromForm)
    // Route::post('/store', [AnimeController::class, 'store'])->name('animes.store');
    // Exibir formulário de edição (já coberto por /animes/{id}/edit)
    // Route::get('/{id}/edit', [AnimeController::class, 'edit'])->name('animes.edit');
    // Processar atualização (já coberto por /animes/{id} com PUT e updateFromForm)
    // Route::put('/{id}', [AnimeController::class, 'update'])->name('animes.update'); // Cuidado: 'update' é o da API, 'updateFromForm' é o do HTML
    // Excluir anime (já coberto por /anime/{id} com DELETE)
    // Route::delete('/{id}', [AnimeController::class, 'destroy'])->name('animes.destroy');
    // Filtros e cálculos (se forem para API, mova para um grupo de API)
    // Route::get('/filtro', [AnimeController::class, 'filtro'])->name('animes.filtro');
});
*/

require __DIR__.'/auth.php'; // Rotas de autenticação padrão do Laravel