<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

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

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "acess_token" => $token,
                "token_type" => 'Bearer'
            ]);
        }

        return response()->json([
            "message" => "Usuário Inválido"
        ]);
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
            "password" => "required|string|min:6"
        ]);

        $user = User::create([
            "email" => $request->email,
            "name" => $request->name,
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
}
