<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('num_documento')->unique();
            $table->string('correo')->unique();
            $table->string('direccion_domicilio')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('cargo', ['tecnico', 'soporte_tecnico', 'dirigidor', 'planta_externa', 'vendedor'])->default('tecnico');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
