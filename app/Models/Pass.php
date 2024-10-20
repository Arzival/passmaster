<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
    
    // Relación inversa: Una contraseña pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
