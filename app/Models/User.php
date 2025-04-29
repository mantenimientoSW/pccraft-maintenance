<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Orden;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'cellphone',
        'email',
        'password',
    ];

    // Relación uno a muchos con Direccion
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'ID_Usuario', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Este metodo sirve para la plantilla de AdminLTE, NO quitar!!!
    public function adminlte_image(){
        return asset('img/user_profile.png');
    }

    // Relacion con la tabla 'ordens'
    public function ordens()
    {
        return $this->hasMany(Orden::class, 'ID_Usuario');
    }
}
