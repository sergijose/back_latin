<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    public function getImagenUrlAttribute()
    {
        // Devuelve la URL de la imagen o una genérica si es nula
        return $this->imagen 
            ? asset('storage/' . $this->imagen) 
            : asset('images/sin_imagen.jpg');
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class);
    }

    public function productoDetalle(){
        return $this->hasMany(ProductoDetalle::class);
    }
}
