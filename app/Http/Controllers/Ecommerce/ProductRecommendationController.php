<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductRecommendation;

class ProductRecommendationController extends Controller
{
    /**
     * @return products productos mas vendidos durante el mes pasado
     */
    public static function getProducts()
    {
        $productosRecomendados = ProductRecommendation::select(
                'recomendaciones.*',
                'products.precio',
                'products.descuento',
                DB::raw('products.precio - (products.precio * (products.descuento / 100)) as precioFinal')
            )
            ->join('products', 'recomendaciones.ID_producto', '=', 'products.ID_producto')
            ->get();
        return $productosRecomendados;
    }
}
