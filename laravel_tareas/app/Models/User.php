<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Le decimos el nombre real de tu tabla
    protected $table = 'usuarios';

    // 2. Le indicamos cuál es tu llave primaria
    protected $primaryKey = 'id_usuario';

    // 3. Opcional: Si tu tabla no tiene created_at y updated_at
    public $timestamps = false;

    // 4. Las columnas que se pueden llenar
    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'rol',
    ];
   

    // 5. Ocultamos el password por seguridad cuando se imprima el usuario
    protected $hidden = [
        'password_hash',
    ];
     //Obtener password hash de la base de datos para laravel
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
}
