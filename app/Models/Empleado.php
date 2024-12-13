<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'empleados';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_completo',
        'num_documento',
        'correo',
        'direccion_domicilio',
        'fecha_nacimiento',
        'cargo',
        'estado',
        'user_id',
    ];

    /**
     * Relación con el modelo de usuario.
     * Un empleado puede estar relacionado con un usuario del sistema.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
