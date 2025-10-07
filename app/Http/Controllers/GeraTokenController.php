<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Models\UserToken;
use Carbon\Carbon;

class GeraTokenController extends Controller
{
    public function gera(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $user = $request->user();
            event(new Registered($user));
            Mail::to('testreceiver@gmail.com')->send(new WelcomeMail($user->id));

            if($user->validado !== 'S') {
            return response()->json([
                "message" => "Por favor, verifique seu e-mail antes de fazer login."
            ], 403); 
            }

           $user = Auth::user();

            // Gera o token string primeiro
            $tokenString = md5($request->password . $request->email . Carbon::now());
            
            $usertoken = new UserToken();
            $usertoken->user_id = $user->id;
            $usertoken->token = $tokenString; // Usa a variável do token
            $usertoken->valido_ate = Carbon::now()->addDays(7);
            $usertoken->save();

            return response()->json([
                "acess_token" => $tokenString, // ✅ Retorna a STRING do token
                "token_type" => 'Bearer',
                "expires_in" => 604800, // 7 dias em segundos
                "user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ]);
        }

        return response()->json([
            "message" => "Usuário Inválido"
        ], 401);
    }

     public function validar_email($codigo){

        $codigo = User::where('codigo','=',$codigo)->get()->first();

        if($codigo){
            $codigo->validado = 'S';
            $codigo->save();
            return view("deu")->with('usuario',$codigo)->with("achou","S");
        }else{
            $codigo = new User();
            return view("naodeu")->with('usuario',$codigo)->with("achou","N");;
        }
     }

    public function registrauser(Request $request)
    {
        $request->validate([
            "email" => "required|string|email|unique:users",
            "name" => "required|string",
            "username" => "required|string|unique:users",
            "password" => "required|string|min:6"
        ]);

        $user = User::create([
            "email" => $request->email,
            "name" => $request->name,
            "username" => $request->username,
            "password" => Hash::make($request->password),
            "validado" => 'N',
            "codigo" => str(rand(1000, 9999))
        ]);

        event(new Registered($user));
        Mail::to('testreceiver@gmail.com')->send(new WelcomeMail($user->id));

        return response()->json([
            "message" => "Sucesso",
            "user" => $user
        ]);
    }

    // Método adicional para logout (opcional)
    public function logout(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        
        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Bearer ')) {
            $token = substr($authorizationHeader, 7);
            UserToken::where('token', $token)->delete();
        }

        Auth::logout();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}