<?php

namespace App\Http\Controllers\Ecommerce;

use DateTime;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ecommerce\ProductRecommendationController;

class ProductController extends Controller
{
    //
    public function index(Product $product)
{
    $user = User::find( auth()->id() );

    // Calcular el precio final
    $precioFinal = (100 - $product->descuento) * 0.01 * $product->precio ;
    $product->precio_final = number_format($precioFinal, 2, '.', ',');

    // Parse JSON Especificaciones
    $product->especificaciones = json_decode($product->especificacionJSON, true);

    $filtro = request('filtro', 'mas-recientes');

    // Obtener comentarios ordenados según el filtro
    $comentarios = $product->reviews()
    ->with('productoOrdens.orden.usuario')
    ->orderBy('fecha', 'desc')
    //->orderBy('updated_at', 'desc')
    ->get();
        

    $product->comentarios = $comentarios;
    $product->avgRaiting = $product->reviews()->avg('calificacion') ?? 0;

    // Si es una solicitud AJAX, devolver solo el HTML de los comentarios
    if (request()->ajax()) {
        return response()->json([
            'html' => view('ecommerce.product', compact('product'))->render()
        ]);
    }
    
    // Inicializar valores de compra y reseña
    $product->comprado = false;
    $product->resenado = false;
    $product->ultimaOrdenEntregada = null;

    if ($user) {
        $idProducto = $product->ID_producto;
    
        // Verificar si el usuario ha comprado el producto
        $productoOrden = $user->ordens()
            ->whereHas('productos', function ($query) use ($idProducto) {
                $query->where('producto__ordens.ID_Producto', $idProducto);
            })
            ->with(['productos' => function ($query) use ($idProducto) {
                $query->where('producto__ordens.ID_Producto', $idProducto);
            }])->get();
    
        // Verificar si el producto ha sido comprado
        if ($productoOrden->isNotEmpty()) {
            $product->comprado = true;
    
            // Verificar si hay una reseña asociada en la tabla pivote
            foreach ($productoOrden as $orden) {
                $productoComprado = $orden->productos->first();
                if ($productoComprado && $orden->estado === 'entregado' && !$productoComprado->pivot->ID_Review) {
                    $product->ultimaOrdenEntregada = $orden; // Guardamos la orden entregada
                    $product->resenado = false;
                    break;
                } else {
                    $product->resenado = true;
                }
            }
        }
    }

    $productosRecomendados = ProductRecommendationController::getProducts();

    return view('ecommerce.product', compact('product', 'productosRecomendados'));
}

public function show($id)
{
    $product = Producto::findOrFail($id);

    // Obtener el valor del filtro de la solicitud
    $filtro = request('filtro', 'mas-recientes');

    // Obtener comentarios ordenados según el filtro
    $comentarios = $product->reviews()
    ->with('productoOrdens.orden.usuario')
    ->orderBy('fecha', 'desc')
    //->orderBy('updated_at', 'desc')
    ->get();

    $product->comentarios = $comentarios;

    if (request()->ajax()) {
        // Si es una solicitud AJAX, devolver solo la sección de comentarios renderizada
        return view('ecommerce.product', compact('product'))->renderSections()['comentarios-container'];
    }

    // Si no es AJAX, cargar la vista completa
    return view('ecommerce.product')->with('product', $product);
}


}
