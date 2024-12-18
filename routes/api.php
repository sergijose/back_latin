<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoDetalleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Rutas de autenticación

Route::prefix('v1/auth')->group(function(){

    Route::post('login', [AuthController::class, "funLogin"]);
    Route::post('register', [AuthController::class, "funRegister"]);
    
    Route::middleware('auth:sanctum')->group(function(){
    
        Route::get('profile', [AuthController::class, "funProfile"]);
        Route::post('logout', [AuthController::class, "funLogout"]);
        
    });
});

Route::middleware('auth:sanctum')->group(function(){

    
    Route::get("categoria-listar", [CategoriaController::class, "listarCategoria"]);
    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource('producto-detalle', ProductoDetalleController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);
    Route::apiResource("usuario", UsuarioController::class);
    Route::apiResource("persona", PersonaController::class);
    Route::apiResource("documento", DocumentoController::class);
    Route::apiResource("role", RoleController::class);
    Route::apiResource("empleado", EmpleadoController::class);
    Route::put('/empleado/{id}/assign-user', [EmpleadoController::class, 'assignUser']);

});




