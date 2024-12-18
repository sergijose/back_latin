<?php

namespace App\Http\Controllers;

use App\Models\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?page=1&limit=10&q=teclado
        $limit = isset($request->limit) ? $request->limit : 10;
        $q = $request->q;
        if ($q) {
            $productos = Producto::where("nombre", "like", "%$q%")
                ->orWhere("precio_venta", "like", "%$q%")
                ->orWhere("tipo", "like", "%$q%")
                ->orWhereHas("categoria", function ($query) use ($q) {
                    $query->where("nombre", "like", "%$q%");
                })
                ->with(["categoria"])
                ->orderBy('id', 'desc')
                ->paginate($limit);
        } else {
            $productos = Producto::with(["categoria"])->orderBy('id', 'desc')->paginate($limit);
        }

        return response()->json($productos, 200);
    }

    public function funGetProductos()
    {
        $productos = Producto::get()->take(3);
        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|min:3|max:255|unique:productos,nombre",
            "categoria_id" => "required|exists:categorias,id",
            //"imagen" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048", // Validar imagen
        ]);
        // subida de imagen
        /*
        $direccion_imagen = "";
        if($file = $request->file("imagen")){
            $url_imagen = time() . "-" .$file->getClientOriginalName();
            $file->move("imagenes/", $url_imagen);

            $direccion_imagen = "imagenes/" . $url_imagen;
        }
            */
           
        // registrar el producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->unidad_medida = $request->unidad_medida;
        $producto->cantidad_medida = $request->cantidad_medida;
        $producto->tipo = $request->tipo;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria_id;
        //$producto->imagen = $direccion_imagen;

        if ($file = $request->file('imagen')) {
            $nombre_imagen = time() . '-' . $file->getClientOriginalName();
            $ruta = public_path('storage/imagenes');
        
            // Crea el directorio si no existe
            if (!file_exists($ruta)) {
                mkdir($ruta, 0755, true);
            }
        
            // Mueve la imagen directamente a public/storage/imagenes
            $file->move($ruta, $nombre_imagen);
        
            // Guarda la ruta en la base de datos
            $producto->imagen = 'storage/imagenes/' . $nombre_imagen;
        }
      
        $producto->save();

        return response()->json(["mensaje" => "Producto registrado correctamente"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with(["categoria"])->find($id);

        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required|min:3|max:255|unique:productos,nombre,$id",
           "categoria_id" => "required|exists:categorias,id",
        ]);
        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->unidad_medida = $request->unidad_medida;
        $producto->cantidad_medida = $request->cantidad_medida;
        $producto->tipo = $request->tipo;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria_id;
    // Manejar imagen si se sube una nueva
    if ($file = $request->file('imagen')) {
        // Eliminar la imagen anterior si existe
        if ($producto->imagen && file_exists(public_path($producto->imagen))) {
            unlink(public_path($producto->imagen)); // Eliminar del directorio público
        }

        // Guardar la nueva imagen
        $nombre_imagen = time() . '-' . $file->getClientOriginalName();
        $direccion_imagen = $file->storeAs('imagenes', $nombre_imagen, 'public'); // Guardar en storage/app/public/imagenes

        // Actualizar la ruta de la imagen en la base de datos
        $producto->imagen = 'storage/' . $direccion_imagen; // Ruta accesible públicamente
    }

        $producto->update();

        return response()->json(["mensaje" => "Producto modificado correctamente"], 201);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);
        // Verificar si el producto tiene una imagen y eliminarla
    if ($producto->imagen && file_exists(public_path($producto->imagen))) {
        unlink(public_path($producto->imagen)); // Eliminar la imagen del servidor
    }
        $producto->delete();

        return response()->json(["mensaje" => "Producto Eliminado"], 200);
    }
}
