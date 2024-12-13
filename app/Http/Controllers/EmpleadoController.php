<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Listar todos los empleados.
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit)?$request->limit:10;
        $q = $request->q;
        if($q){
        $empleados = Empleado::with('usuario')->get()
        ->orWhere("nombre_completo", "like", "%$q%")
        ->orWhere("estado", "like", "%$q%")
        ->orWhere("cargo", "like", "%$q%")
        ->orderBy('id', 'desc')
        ->paginate($limit);
    }else{
        $empleados = Empleado::with(["usuario"])->orderBy('id', 'desc')->paginate($limit);
    }

    return response()->json($empleados, 200);
    }

    /**
     * Crear un nuevo empleado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'num_documento' => 'required|string|max:20|unique:empleados,num_documento',
            'correo' => 'required|email|max:255|unique:empleados,correo',
            'direccion_domicilio' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'cargo' => 'required|in:tecnico,soporte_tecnico,dirigidor,planta_externa,vendedor',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $empleado = Empleado::create($validated);

        return response()->json(['message' => 'Empleado creado con éxito.', 'empleado' => $empleado], 201);
      
    }

    /**
     * Actualizar la información de un empleado.
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre_completo' => 'sometimes|required|string|max:255',
            'num_documento' => 'sometimes|required|string|max:20|unique:empleados,num_documento,' . $empleado->id,
            'correo' => 'sometimes|required|email|max:255|unique:empleados,correo,' . $empleado->id,
            'direccion_domicilio' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'cargo' => 'sometimes|required|in:tecnico,soporte_tecnico,dirigidor,planta_externa,vendedor',
            'estado' => 'sometimes|required|in:activo,inactivo',
        ]);

        $empleado->update($validated);

        return response()->json(['message' => 'Empleado actualizado con éxito.', 'empleado' => $empleado]);
    }

    /**
     * Eliminar un empleado.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado con éxito.']);
    }

    /**
     * Asignar un usuario existente a un empleado.
     */
    public function assignUser(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $empleado->user_id = $validated['user_id'];
        $empleado->save();

        return response()->json(['message' => 'Usuario asignado al empleado con éxito.', 'empleado' => $empleado]);
    }
}
