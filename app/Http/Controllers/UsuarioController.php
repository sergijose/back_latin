<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use function Laravel\Prompts\confirm;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $usuarios = User::with(["empleado"])->where("name", "LIKE", "%$request->q%")->get();

        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
        ]);
        // guardar
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();

        return response()->json(["mensaje" => "Usuario registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);

        return response()->json($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
            "password" => "required",
        ]);
        
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->update();

        return response()->json(["mensaje" => "Usuario actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);
        $usuario->delete();
        return response()->json(["mensaje" => "Usuario Eliminado"], 200);        
    }
}
