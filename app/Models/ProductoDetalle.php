<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoDetalle extends Model
{
    use HasFactory;

    protected $table = 'producto_detalle';

    protected $fillable = [
        'codigo',
        'producto_id',
        'serie',
        'mac',
        'estado_prestamo',
        'estado_fisico',
        'observaciones'
    ];

  
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function cambiarEstado($nuevoEstado)
    {
        $estadosValidos = ['DISPONIBLE', 'PRESTADO', 'DEVUELTO', 'EN_REVISION'];

        if (in_array($nuevoEstado, $estadosValidos)) {
            $this->estado_prestamo = $nuevoEstado;
            $this->save();
        } else {
            throw new \Exception("Estado no válido.");
        }
    }
}
