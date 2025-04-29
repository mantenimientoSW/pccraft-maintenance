<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Ecommerce\ProductRecommendationController;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecomendacionController extends Controller
{
    //
    public static function index()
    {
        $fechaActual = Carbon::now()->subMonth()->toDateString();
        // dd($fechaActual);
        // Consulta para obtener los productos más vendidos del último mes
        $productosMasVendidos = Product::select( 'products.ID_producto', 'products.nombre', 'products.modelo', DB::raw('SUM(producto__ordens.cantidad) as total_vendidos'))
            ->join('producto__ordens', 'products.ID_producto', '=', 'producto__ordens.ID_Producto')
            ->join('ordens', 'producto__ordens.ID_Orden', '=', 'ordens.ID_Orden')
            ->where('ordens.fecha', '>=', Carbon::now()->subMonth()->toDateString())
            ->where('ordens.estado', '!=', 'cancelado')
            // //!Considerar otro estado del pedido 
            // ->where('ordens.estado', 'completado')
            // ->orwhere('ordens.estado', 'pedido')
            ->groupBy('products.ID_producto', 'products.nombre', 'products.modelo')
            ->orderBy('total_vendidos', 'desc')
            ->limit(15)
            ->get();
        
        $productosRecomendados = ProductRecommendationController::getProducts();

        // dd( count($productosMasVendidos) );
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
        // Retornar los productos a la vista o en formato JSON
        return view('ecommerce/recomendaciones', compact('productosMasVendidos', 'fechaActual', 'productosRecomendados'));
    }
}
