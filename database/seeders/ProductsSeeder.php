<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = json_decode(file_get_contents('productos-1.json'), true);

        foreach ($jsonData['productos'] as $productData) {
            Product::create([
                'nombre' => $productData['nombre'],
                'modelo' => $productData['modelo'],
                'fabricante' => $productData['fabricante'],
                'descripcion' => $productData['descripcion'],
                'precio' => $productData['precio'],
                'descuento' => $productData['descuento'],
                'stock' => $productData['stock'],
                'ID_Categoria' => $productData['ID_categoria'],
                'especificacionJSON' => json_encode($productData['especificacionesJSON']),
                //DENTRO DEL JSON, Cambiar de objeto a array y es "photos" no "photo"
                //revisa el primer producto para referecia
                //cambiar llaves por corchetes
                'url_photo' => json_encode($productData['url_photo']),
                'vendidos' => 0,
            ]);
        }
    }
}
