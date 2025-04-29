<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateProductRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the product recommendations based on the best-selling products of the month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener los productos más vendidos del último mes
        $productosMasVendidos = Product::select( 'products.ID_producto', 'products.nombre', 'products.modelo', DB::raw('SUM(producto__ordens.cantidad) as total_vendidos'))
            ->join('producto__ordens', 'products.ID_producto', '=', 'producto__ordens.ID_Producto')
            ->join('ordens', 'producto__ordens.ID_Orden', '=', 'ordens.ID_Orden')
            ->where('ordens.fecha', '>=', Carbon::now()->subMonth()->toDateString())
            ->where('ordens.estado', '!=', 'cancelado')
            ->groupBy('products.ID_producto', 'products.nombre', 'products.modelo')
            ->orderBy('total_vendidos', 'desc')
            ->limit(15)
            ->get();

        // Actualizar los productos en una tabla de recomendaciones.
        DB::table('recomendaciones')->truncate(); // Limpia la tabla de recomendaciones
        foreach ($productosMasVendidos as $producto) {
            DB::table('recomendaciones')->insert([
                'ID_producto' => $producto->ID_producto,
                'total_vendidos' => $producto->total_vendidos,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Recomendaciones actualizadas correctamente.');
    }
}
