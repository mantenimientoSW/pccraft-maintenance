<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecommendation extends Model
{
    use HasFactory;
    protected $table = 'recomendaciones';
    protected $primaryKey = 'ID_Recomendacion';
    protected $fillable = [
        'ID_producto',
        'total_vendidos'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ID_producto', 'ID_producto');
    }
}
