<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direccions';
    protected $primaryKey = 'ID_Direccion';
    protected $fillable = [
        'ID_Usuario',
        'ciudad',
        'codigo_postal',
        'calle_principal',
        'cruzamientos',
        'numero_exterior',
        'numero_interior',
        'detalles',
        'is_default',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }
    public function ordenes()
    {
        return $this->hasMany(Order::class, 'ID_Direccion');
    }

    public $timestamps = false;  // Si tu tabla de direcciones no tiene columnas created_at/updated_at
}
