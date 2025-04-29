<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ordens')->insert([
            [
                'ID_Usuario' => 1,
                'ID_Direccion' => 1,
                'fecha' => Carbon::now()->subDays(12),
                'total' => 4506.40,
                'estado' => 'entregado',
                'fecha_enviado' => Carbon::now()->subDays(10),
                'fecha_cancelado' => null,
                'fecha_entregado' => Carbon::now()->subDays(6),
                'stripe_id' => 'ch_1ExampleStripeId1',
            ],
            [
                'ID_Usuario' => 1,
                'ID_Direccion' => 1,
                'fecha' => Carbon::now()->subDays(8),
                'total' => 1567.04,
                'estado' => 'enviado',
                'fecha_enviado' => Carbon::now()->subDays(4),
                'fecha_cancelado' => null,
                'fecha_entregado' => null,
                'stripe_id' => 'ch_1ExampleStripeId2',
            ],
            [
                'ID_Usuario' => 1,
                'ID_Direccion' => 2,
                'fecha' => Carbon::now()->subDays(3),
                'total' => 7136.92,
                'estado' => 'pedido',
                'fecha_enviado' => null,
                'fecha_cancelado' => null,
                'fecha_entregado' => null,
                'stripe_id' => 'ch_1ExampleStripeId3',
            ],
            [
                'ID_Usuario' => 2,
                'ID_Direccion' => 3,
                'fecha' => Carbon::now()->subDays(20),
                'total' => 15999.00,
                'estado' => 'cancelado',
                'fecha_enviado' => null,
                'fecha_cancelado' => Carbon::now()->subDays(19),
                'fecha_entregado' => null,
                'stripe_id' => 'ch_1ExampleStripeId4',
            ],
            [
                'ID_Usuario' => 2,
                'ID_Direccion' => 4,
                'fecha' => Carbon::now()->subDays(2),
                'total' => 7964.00,
                'estado' => 'pedido',
                'fecha_enviado' => null,
                'fecha_cancelado' => null,
                'fecha_entregado' => null,
                'stripe_id' => 'ch_1ExampleStripeId5',
            ],
            [
                'ID_Usuario' => 2,
                'ID_Direccion' => 2,
                'fecha' => Carbon::now()->subDays(30),
                'total' => 1455.00,
                'estado' => 'entregado',
                'fecha_enviado' => Carbon::now()->subDays(26),
                'fecha_cancelado' => null,
                'fecha_entregado' => Carbon::now()->subDays(24),
                'stripe_id' => 'ch_1ExampleStripeId6',
            ],
        ]);

        // Asociar productos a las ordenes
        DB::table('producto__ordens')->insert([
            // Orden 1
            [
                'ID_Producto' => 2,
                'ID_Orden' => 1,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 3526.40,
                'agregado' => Carbon::now()->subDays(12),
            ],
            [
                'ID_Producto' => 6,
                'ID_Orden' => 1,
                'ID_Review' => null,
                'cantidad' => 2,
                'precio' => 490.00,
                'agregado' => Carbon::now()->subDays(12),
            ],
            // Orden 2
            [
                'ID_Producto' => 20,
                'ID_Orden' => 2,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 800.00,
                'agregado' => Carbon::now()->subDays(8),
            ],
            [
                'ID_Producto' => 37,
                'ID_Orden' => 2,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 767.04,
                'agregado' => Carbon::now()->subDays(8),
            ],
            // Orden 3
            [
                'ID_Producto' => 34,
                'ID_Orden' => 3,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 5809.00,
                'agregado' => Carbon::now()->subDays(3),
            ],
            [
                'ID_Producto' => 35,
                'ID_Orden' => 3,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 1327.92,
                'agregado' => Carbon::now()->subDays(3),
            ],
            // Orden 4
            [
                'ID_Producto' => 32,
                'ID_Orden' => 4,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 13499.00,
                'agregado' => Carbon::now()->subDays(20),
            ],
            [
                'ID_Producto' => 39,
                'ID_Orden' => 4,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 2500.00,
                'agregado' => Carbon::now()->subDays(20),
            ],
            // Orden 5
            [
                'ID_Producto' => 10,
                'ID_Orden' => 5,
                'ID_Review' => null,
                'cantidad' => 4,
                'precio' => 616.00,
                'agregado' => Carbon::now()->subDays(2),
            ],
            [
                'ID_Producto' => 23,
                'ID_Orden' => 5,
                'ID_Review' => null,
                'cantidad' => 1,
                'precio' => 5500.00,
                'agregado' => Carbon::now()->subDays(2),
            ],
            // Orden 6
            [
                'ID_Producto' => 11,
                'ID_Orden' => 6,
                'ID_Review' => null,
                'cantidad' => 2,
                'precio' => 1455.00,
                'agregado' => Carbon::now()->subDays(30),
            ]
        ]);
    }
}
