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
        Schema::create('producto_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->string('codigo', 10)->unique();
            $table->string('serie', 100)->unique()->nullable();
            $table->string('mac', 100)->unique()->nullable();
            $table->enum('estado_prestamo', [
                'DISPONIBLE',
                'PRESTADO',
                'DEVUELTO',
                'EN REVISION'
            ])->default('DISPONIBLE');
            $table->enum('estado_fisico', [
                'OPERATIVO',
                'DAÑADO',
                'EN REPARACION'
            ])->default('OPERATIVO');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_detalle');
    }
};
