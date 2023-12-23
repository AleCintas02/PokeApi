<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use App\Models\Equipo;
use App\Models\Pokemon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function crear(Request $request, $id_entrenador)
    {
        try {
            $entrenador = Entrenador::findOrFail($id_entrenador);


            $equipo = Equipo::create([
                'nombre' => $request->nombre,

            ]);


            $entrenador->equipos()->save($equipo);

            return response()->json([
                'status' => 'ok',
                'id_equipo' => $equipo->id,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El entrenador no fue encontrado.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function crearEquipoConPokemones($id_equipo)
    {
        $equipo = Equipo::find($id_equipo);

        if (!$equipo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Equipo no encontrado',
            ], 404);
        }

        $cantidad = 3;

        $pokemonIds = DB::table('pokemones')
            ->whereNotIn('id', function ($query) use ($equipo) {
                $query->select('id_pokemones')
                    ->from('equipos_pokemones')
                    ->where('id_equipos', $equipo->id);
            })
            ->inRandomOrder()
            ->take($cantidad)
            ->pluck('id')
            ->toArray();

        if (count($pokemonIds) < $cantidad) {
            return response()->json([
                'status' => 'error',
                'message' => 'No hay suficientes pokemones disponibles para este equipo',
            ], 400);
        }

        $ultimoOrden = $equipo->pokemones()->max('orden');
        $orden = $ultimoOrden ? $ultimoOrden + 1 : 1;

        foreach ($pokemonIds as $pokemonId) {
            $equipo->pokemones()->attach($pokemonId, ['orden' => $orden]);
            $orden++;
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Equipo creado con pokemones y orden aleatorio',
        ], 200);
    }


    public function listarEquipos()
    {
        $equiposConPokemones = Equipo::with('pokemones')->get();

        return response()->json([
            'status' => 'ok',
            'equipos' => $equiposConPokemones,
        ], 200);
    }
}
