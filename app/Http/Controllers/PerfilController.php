<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Retorna os dados do perfil do usuário autenticado.
     */
    public function show($id = null)
    {
        // Se não passar ID, usa o usuário autenticado
        $userId = $id ?? Auth::id();
        $user = User::findOrFail($userId);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 200);
    }

    /**
     * Atualiza as informações do perfil do usuário.
     */
    public function update(Request $request, $id = null)
    {
        // Se não passar ID, usa o usuário autenticado
        $userId = $id ?? $request->user()->id;
        $user = User::findOrFail($userId);

        // Validação dos dados
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'discord' => 'nullable|string|max:100',
            'twitter' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'tiktok' => 'nullable|string|max:100',
            'snapchat' => 'nullable|string|max:100',
            'avatarpf' => 'nullable|string',
            'coverp' => 'nullable|string',
        ]);

        // Atualização do usuário
        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Perfil atualizado com sucesso!',
            'user' => $user->fresh()
        ], 200);
    }

    /**
     * Busca usuário por ID (para perfis públicos)
     */
    public function getById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 200);
    }
}