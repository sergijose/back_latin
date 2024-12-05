<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = DB::select("select * from roles");

        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        DB::insert("insert into roles (nombre, detalle, created_at, updated_at) 
                    values('$request->nombre', '$request->detalle', NOW(), NOW())"); */
        /*
        DB::insert("insert into roles (nombre, detalle, created_at, updated_at) 
                    values(:nombre, :detalle, NOW(), NOW())", ["nombre" => $request->nombre, "detalle" => $request->detalle ?? null]);
        */
        DB::insert("insert into roles (nombre, detalle, created_at, updated_at) 
                    values(:nombre, :detalle, NOW(), NOW())", [$request->nombre, $request->detalle]);


        return response()->json(["mensaje" => "ROle Registrado correctamente"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = DB::select("select * from roles where id = :id", ["id" => $id]);
        if(count($role)>0){
            return response()->json($role[0], 200);
        }
        return response()->json(["message" => "Role no existe"], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $modificado = DB::update('
            UPDATE roles
            SET nombre = :nombre, detalle= :detalle, updated_at = NOW()
            WHERE id= :id
        ', [
            "nombre" => $request->nombre,
            "detalle" => $request->detalle,
            "id" => $id
        ]);

        if($modificado){
            return response()->json(["message" => "Role actualizado corretamente"], 200);
        }
        return response()->json(["message" => "Role no existe"], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eliminado = DB::delete("DELETE from roles where id= :id", ["id" => $id]);

        if($eliminado){
            return response()->json(["message" => "Role Eliminado"], 200);
        }
        return response()->json(["message" => "Role no existe"], 404);
    }
}
