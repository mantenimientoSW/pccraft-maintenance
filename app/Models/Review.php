<?php

namespace App\Models;

use App\Models\Producto_Orden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Review extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $primaryKey = 'ID_Review';
    protected $fillable = [
        'titulo',
        'comentario',
        'calificacion',
        'fecha'
    ];


    // Relación directa con la tabla pivot 'producto__ordens'
    public function productoOrdens()
    {
        return $this->hasOne(Producto_Orden::class, 'ID_Review');
    }
}
