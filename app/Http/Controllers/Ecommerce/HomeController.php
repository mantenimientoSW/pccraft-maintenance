<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ecommerce\ProductRecommendationController;

class HomeController extends Controller
{
    public function index(){
        
        $productosRecomendados = ProductRecommendationController::getProducts();

        return view('ecommerce.home', compact('productosRecomendados'));
    }
}
