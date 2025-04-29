<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'attributes',
    ];
    public $timestamps = false;
    // Relación con la tabla "categories"
    public function category()
    {
        return $this->belongsTo(Category::class, 'ID_Categoria', 'ID_Categoria');
    }
}