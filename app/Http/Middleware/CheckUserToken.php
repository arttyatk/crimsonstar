<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckUserToken
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pega o token do cabeçalho de autorização.
        // O token deve ser enviado no formato 'Bearer SEU_TOKEN_AQUI'
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json(['message' => 'Token não fornecido.'], 401);
        }

        // Remove 'Bearer ' para obter apenas o token.
        $token = substr($authorizationHeader, 7);
        
        // Busca o token no banco de dados.
        $userToken = UserToken::where('token', $token)->first();

        // Verifica se o token existe e se não está expirado.
        if (!$userToken || Carbon::now()->gt($userToken->valido_ate)) {
            return response()->json(['message' => 'Token inválido ou expirado.'], 401);
        }

        // Se o token é válido, autentica o usuário na requisição.
        $user = $userToken->user;
        if ($user) {
            Auth::login($user); // Isso autentica o usuário para a requisição atual.
        }

        return $next($request);
    }
}