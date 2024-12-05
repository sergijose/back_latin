<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $per1 = new Persona();
        $per1->nombre_completo = "JUAN";
        $per1->apellidos = "PAREDEZ";
        $per1->fecha_nacimiento = "1990-12-12";
        $per1->user_id = 1;
        $per1->save();
    }
}
