<?php

namespace App\View\Components\Ecommerce;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductosRecomendados extends Component
{
    public $productosRecomendados;

    /**
     * Create a new component instance.
     */
    public function __construct($productosRecomendados)
    {
        $this->productosRecomendados = $productosRecomendados;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('ecommerce.components.productos-recomendados');
    }
}
