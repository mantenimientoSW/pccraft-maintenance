<?php

namespace App\Models;

use App\Models\Orden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_producto';
    protected $fillable = [
        'nombre',
        'modelo',
        'fabricante',
        'descripcion',
        'precio',
        'descuento',
        'stock',
        'fecha_agregada',
        'ID_Categoria',
        'especificacionJSON',
        'url_photo',
        'vendidos',
    ];
    public $timestamps = false;
    // Relación con la tabla "categories"
    public function category()
    {
        return $this->belongsTo(Category::class, 'ID_Categoria', 'ID_Categoria');
    }

    // Relación directa con la tabla pivot 'producto__ordens'
    public function productoOrdens()
    {
        return $this->hasMany(Producto_Orden::class, 'ID_Producto', 'ID_producto');
    }

    // Todas las reviews de un producto
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Producto_Orden::class, 'ID_Producto', 'ID_Review', 'ID_producto', 'ID_Review');
    }
}

            