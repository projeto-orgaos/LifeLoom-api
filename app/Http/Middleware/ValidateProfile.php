<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$allowedProfiles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowedProfiles)
    {
        $user = $request->user();

        // Verifica se o usuário está autenticado
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        // Verifica se o profile_id do usuário está na lista de perfis permitidos
        if (!in_array($user->profile_id, $allowedProfiles)) {
            return response()->json(['message' => 'Acesso negado. Perfil não autorizado.'], 403);
        }

        return $next($request);
    }
}
