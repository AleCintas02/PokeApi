<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    public $table = "pokemones";

    protected $fillable = ['id', 'nombre', 'tipo'];
    public $timestamps = false;

    public function equipo()
    {
        return $this->belongsToMany(Equipo::class, 'equipos_pokemones', 'id_pokemones', 'id_equipos')
            ->withPivot('orden')
            ->withTimestamps();
    }
}
