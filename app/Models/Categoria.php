<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // protected $table = 'wp_categoria';

    // protected $primaryKey = 'idcat';
    // public $incrementing = false;
    // protected $keyType = 'string';

    // public $timestamps = false;

    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
