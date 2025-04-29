<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DireccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('direccions')->insert([
            [
                'ID_Usuario' => 1,
                'ciudad' => 'Mérida',
                'codigo_postal' => '97301',
                'calle_principal' => 'Calle 33',
                'cruzamientos' => 'Calle 49 y 51',
                'numero_exterior' => '101',
                'numero_interior' => null,
                'detalles' => 'Detalles adicionales 1',
                'is_default' => 1,
            ],
            [
                'ID_Usuario' => 1,
                'ciudad' => 'Timucuy',
                'codigo_postal' => '54031',
                'calle_principal' => 'Calle 48',
                'cruzamientos' => 'Calle 18 y 20',
                'numero_exterior' => '42',
                'numero_interior' => null,
                'detalles' => 'Detalles adicionales 2',
                'is_default' => 0,
            ],
            [
                'ID_Usuario' => 2,
                'ciudad' => 'Cancún',
                'codigo_postal' => '775524',
                'calle_principal' => 'Calle 10',
                'cruzamientos' => 'Calle 15 y 19 Nte.',
                'numero_exterior' => '62',
                'numero_interior' => 'C',
                'detalles' => 'Detalles adicionales 3',
                'is_default' => 0,
            ],
            [
                'ID_Usuario' => 2,
                'ciudad' => 'Mérida',
                'codigo_postal' => '97130',
                'calle_principal' => 'Calle 3',
                'cruzamientos' => 'Calle 12 y 14',
                'numero_exterior' => '212',
                'numero_interior' => null,
                'detalles' => 'Detalles adicionales 4',
                'is_default' => 1,
            ],
        ]);
    }
}
