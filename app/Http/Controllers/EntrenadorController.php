<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Exception;
use Illuminate\Http\Request;

class EntrenadorController extends Controller
{
    public function crear(Request $request)
    {
        $nombre = $request->nombre;
        try {
            if (empty($nombre)) {
                throw new Exception("Debe Ingresar el nombre.");
            }
            $entrenador = Entrenador::create([
                'nombre' => $nombre
            ]);
            return [
                'status' => 'ok',
                'id_entrenador' => $entrenador->id
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function listar()
    {
        $entrenadores = Entrenador::all();

        return response()->json([
            'status' => 'ok',
            'entrenadores' => $entrenadores
        ], 200);
    }

    public function detallar($id_entrenador)
    {
        $entrenador = Entrenador::with('equipos')->find($id_entrenador);

        if (!$entrenador) {
            return response()->json([
                'status' => 'error',
                'message' => 'Entrenador no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'ok',
            'entrenador' => $entrenador
        ], 200);
    }
}
