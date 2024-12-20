<?php

namespace App\Http\Controllers;

use App\Models\ProductoDetalle;
use Illuminate\Http\Request;

class ProductoDetalleController extends Controller
{
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $q = $request->q;
        if ($q) {
            $detalle = ProductoDetalle::where("codigo", "like", "%$q%")
                ->orWhere("serie", "like", "%$q%")
                ->orWhere("mac", "like", "%$q%")
                ->orWhere("estado_prestamo", "like", "%$q%")
                ->orWhere("estado_fisico", "like", "%$q%")
                ->orWhere("observaciones", "like", "%$q%")
                ->orWhereHas("producto", function ($query) use ($q) {
                    $query->where("nombre", "like", "%$q%");
                })
                ->with(["producto.categoria"])
                ->orderBy('id', 'desc')
                ->paginate($limit);
        } else {
            $detalle = ProductoDetalle::with(["producto.categoria"])->orderBy('id', 'desc')->paginate($limit);
        }
        return response()->json($detalle, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'codigo' => 'string|unique:producto_detalle,codigo|max:10',
            'serie' => 'nullable|string|unique:producto_detalle,serie|max:100',
            'mac' => 'nullable|string|unique:producto_detalle,mac|max:100',
            'estado_prestamo' => 'nullable|in:DISPONIBLE,PRESTADO,DEVUELTO,EN REVISION',
            'estado_fisico' => 'nullable|in:OPERATIVO,DAÑADO,EN REPARACION',
            'observaciones' => 'nullable|string',
        ]);

        $detalle = ProductoDetalle::create($request->all());
        return response()->json(["mensaje" => "Equipo registrado correctamente", "detalle" => $detalle], 201);
    }


    public function show($id)
    {
        $detalle = ProductoDetalle::with('producto')->findOrFail($id);
        return response()->json($detalle, 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = ProductoDetalle::findOrFail($id);

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'codigo' => 'nullable|string|unique:producto_detalle,serie,' . $detalle->id . '|max:10',
            'serie' => 'nullable|string|unique:producto_detalle,serie,' . $detalle->id . '|max:100',
            'mac' => 'nullable|string|unique:producto_detalle,mac,' . $detalle->id . '|max:100',
            'estado_prestamo' => 'nullable|in:DISPONIBLE,PRESTADO,DEVUELTO,EN REVISION',
            'estado_fisico' => 'nullable|in:OPERATIVO,DAÑADO,EN REPARACION',
            'observaciones' => 'nullable|string',
        ]);

        $detalle->update($request->all());
        return response()->json(["mensaje" => "Equipo modificado correctamente"], 201);
    }

    public function destroy($id)
    {
        $detalle = ProductoDetalle::findOrFail($id);
        $detalle->delete();

        return response()->json(["mensaje" => "Equipo Eliminado"], 200);
    }
}
