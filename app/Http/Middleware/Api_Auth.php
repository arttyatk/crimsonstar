<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserToken;
use Carbon\Carbon;

class Api_Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('user_id') && $request->has('token')){
            $achei = UserToken::where("user_id",$request->user_id)->where("token",$request->token)->where("valido_ate",">=",Carbon::now())->get()->first();

            if($achei){
                return $next($request);
            }else{
                return response(['msg' => "User ID ou token inválidos"], 200);
            }
        }else{
            return response(['msg' => "User ID ou token vazios"], 200);
        }
        return $next($request);
    }
}
