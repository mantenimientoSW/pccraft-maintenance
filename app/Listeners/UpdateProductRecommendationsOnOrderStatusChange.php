<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Support\Carbon;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductRecommendationsOnOrderStatusChange
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Actualizar los productos recomendados con ordenes No Canceladas
     */
    public function handle(OrderStatusChanged $event)
    {
        $this->actualizarRecomendaciones();
    }

    private function actualizarRecomendaciones()
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
        

        // Actualizar la tabla de recomendaciones
        DB::table('recomendaciones')->truncate(); // Limpia la tabla de recomendaciones
        foreach ($productosMasVendidos as $producto) {
            DB::table('recomendaciones')->insert([
                'ID_producto' => $producto->ID_producto,
                'total_vendidos' => $producto->total_vendidos,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
