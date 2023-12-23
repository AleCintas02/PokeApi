<?php

use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('pokemones')->group(function () {
    Route::post('obtener', [PokemonController::class, 'index']);
    /*api/pokemones/obtener*/
    Route::get('listar', [PokemonController::class, 'listar']);
    /*api/pokemones/listar*/
});

Route::prefix('entrenadores')->group(function () {
    Route::post('crear',  [EntrenadorController::class, 'crear']);
    /*Ejemplo para crear entrenador: api/entrenadores/crear
    {
        "nombre": "Entrenador1"
    }*/

    Route::get('listar', [EntrenadorController::class, 'listar']);
    /*/api/entrenadores/listar*/

    Route::get('detallar/{id_entrenador}', [EntrenadorController::class, 'detallar']);
    /*Ejemplo para detallar entrenador:
    /api/entrenadores/detallar/1 
    */
});


Route::prefix('equipos')->group(function () {


    Route::post('crear/{id_entrenador}', [EquipoController::class, 'crear']);
    /*Ejemplo para crear equipo: /api/equipos/crear/{id_entrenador} (id del entrenador que quieres asociar a este equipo)
    {
        "nombre": "Equipo1"
    }
    */

    Route::get('listar', [EquipoController::class, 'listarEquipos']);
    /*Listar equipos: /api/equipos/listar*/

    Route::post('crear-equipo/{id_equipo}', [EquipoController::class, 'crearEquipoConPokemones']);
    /*Crear equipos de 3 pokemones: api/equipos/crear-equipo/{id_equipo} (id del equipo que quieres asociar los 3 pokemones)*/
    /*Ingresa el siguiente cuerpo de la solicitud:
    {
        "nombre": "Equipo1"
    }
    */
});
