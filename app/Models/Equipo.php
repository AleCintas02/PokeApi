<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $table = "equipos";

    protected $fillable = ['id_entrenadores', 'nombre'];

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador');
    }

    public function pokemones()
    {
        return $this->belongsToMany(Pokemon::class, 'equipos_pokemones', 'id_equipos', 'id_pokemones')
            ->withPivot('orden');
    }
}
