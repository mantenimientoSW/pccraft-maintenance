<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    
    protected $table = 'ordens'; // Asegúrate de que esta es tu tabla de órdenes
    protected $primaryKey = 'ID_Orden';
    
    protected $fillable = [
        'ID_Usuario',
        'ID_Direccion',
        'fecha',
        'total',
        'estado',
        'agregada',
        'stripe_id' 
    ];

    public $timestamps = false;

    // Relación con el usuario (cada orden pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario');
    }

    // Relación muchos a muchos con productos (a través de la tabla producto__ordens)
    public function productos()
    {
        return $this->belongsToMany(Product::class, 'producto__ordens', 'ID_Orden', 'ID_Producto')
                    ->withPivot('ID_Review','cantidad', 'precio'); // Añade los campos adicionales de la tabla pivote
    }

    // Relación con dirección (cada orden tiene una dirección)
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'ID_Direccion');
    }
}
