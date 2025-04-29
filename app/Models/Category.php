<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_Categoria';
    protected $fillable = ['nombre_categoria'];

    // Relación con la tabla "products"
    public function products()
    {
        return $this->hasMany(Product::class, 'ID_Categoria');
    }
}
