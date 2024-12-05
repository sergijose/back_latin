<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        // validar
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        // autenticar
        if(!Auth::attempt($credenciales)){
            return response()->json(["mensaje" => "Credenciales Incorrectas"], 401);
        }
        // generar token
        $token = $request->user()->createToken("token auth")->plainTextToken;
        // responder
        return response()->json([
            "access_token" => $token,
            "usuario" => $request->user()
        ], 201);
    }

    public function funRegister(Request $request){
        // validar
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|same:c_password"
        ]);

        // guardamos usuarios
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();

        // respondemos
        return response()->json(["mensaje" => "Usuario Registrado"], 201);

    }

    public function funProfile(Request $request){
        $usuario = $request->user();

        return response()->json($usuario, 200);
    }

    public function funLogout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json(["mensaje" => "Logout"], 200);
    }
}
