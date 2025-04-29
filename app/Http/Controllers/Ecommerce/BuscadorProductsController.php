<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class BuscadorProductsController extends Controller
{
    public function index(Request $request)
    {
        // Inicializar variables a retornar
        $products = [];
        $productToSearch = null;
        $minPrice = null;
        $maxPrice = null;
        
        // Inicializar la consulta de productos con el cálculo de precio final
        $products = Product::select('*', DB::raw('precio - (precio * (descuento / 100)) as precioFinal'))->where('stock',  '>', '0'); // Productos solamente con stock

        // Verificar si hay Busqueda por Nombre/Modelo
        if($request->has('search') && $request->search != ''){
            // Recuperar el producto a buscar
            $productToSearch = $request->query('search');
            // Realizar la query
            $products = Product::where('nombre', 'LIKE', '%' . $productToSearch . '%')
                ->orwhere('modelo', 'LIKE', '%' . $productToSearch . '%')
                ->select('*', DB::raw('precio - (precio * (descuento / 100)) as precioFinal')); // Cálculo del precio final
        }

        // Verificar si hay Filtro por precio
        if( !is_null($request->query('min-price')) || !is_null($request->query('max-price')) ){
            // Recuperar los valores
            $minPrice = (float) $request->query('min-price'); // 0 como valor por defecto si no se envía
            $maxPrice = (float) ($request->query('max-price') ?? 50000.00); // 50000 como valor por defecto si no se envía
            // Condición para filtrar por precioFinal
            $products->havingBetween('precioFinal', [$minPrice, $maxPrice]);
        }

        // Verificar si hay Filtro por Orden
        if( $request->query('order-by') ){
            $this->ordenarBusqueda($request, $products);
        }

        $products = $products->paginate(8);

        return view('ecommerce/buscador')->with([
            'products' => $products,
            'productToSearch' => $productToSearch ?? '',
            'minPrice' => $minPrice ?? 0,
            'maxPrice' => $maxPrice ?? 50000
        ]);
    }

    /** 
        Devuelve los productos según la Category
    */
    public function categorias($categoria, Request $request)
    {
        $products = [];
        $productToSearch = null;
        $orderBy = null;
        $minPrice = null;
        $maxPrice = null;

        //Recuperar todos los productos segun la categoria
        $products = Product::whereHas('category', function($query) use ($categoria){
            $query->where('nombre_categoria', $categoria);
        })->select('*', DB::raw('precio - (precio * (descuento / 100)) as precioFinal')); // Cálculo del precio final

        // Verificar si hay Filtro por precio
        if( !is_null($request->query('min-price')) || !is_null($request->query('max-price')) ){
            // Recuperar los valores
            $minPrice = (float) $request->query('min-price'); // 0 como valor por defecto si no se envía
            $maxPrice = (float) ($request->query('max-price') ?? 50000.00); // 50000 como valor por defecto si no se envía
            // Condición para filtrar por precioFinal
            $products->havingBetween('precioFinal', [$minPrice, $maxPrice]);
        }

        // Verificar si hay Filtro por Orden
        if( $request->query('order-by') ){
            $this->ordenarBusqueda($request, $products);
        }

        $products = $products->paginate(8);

        return view('ecommerce/buscador')->with([
            'products' => $products,
            'productToSearch' => $productToSearch ?? '',
            'minPrice' => $minPrice ?? 0,
            'maxPrice' => $maxPrice ?? 50000
        ]);
    }


    private function ordenarBusqueda(Request $request, $productsQuery)
    {
        // Opciones de ordenamiento
        $ordenarPor = [
            'cheaper' => ['precioFinal' , 'asc'],
            'more-expensive' => ['precioFinal', 'desc'],
            'newest' => ['fecha_agregada', 'desc'],
            'lessnew' => ['fecha_agregada', 'asc']
        ];

        //Recuperar los valores de filtros
        $orderBy = $request->query('order-by');

        // Realizar la ordenacion
        $productsQuery->orderBy( $ordenarPor[$orderBy][0], $ordenarPor[$orderBy][1] );
    }

}
