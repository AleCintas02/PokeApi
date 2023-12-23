<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=15');
        $data = $response->json()['results'];

        foreach ($data as $pokemon) {
            $pokemonDetails = Http::get($pokemon['url'])->json();
            $this->storePokemon($pokemonDetails);
        }

        return response()->json(['message' => 'Pokemons guardados exitosamente.']);
    }

    private function storePokemon($data)
    {
        Pokemon::create([
            'id' => $data['id'],
            'nombre' => $data['name'],
            'tipo' => $data['types'][0]['type']['name'], 
        ]);
    }

    public function listar()
    {
        $pokemones = [];
        try {
            $pokemones = Pokemon::all();
            return [
                'status' => 'ok',
                'pokemones' => $pokemones
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
