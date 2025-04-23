<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    private const CACHE_DURATION = 3600; // 1 hour in seconds

    /**
     * Display a listing of the games.
     */
    public function index()
    {
        return Cache::remember('games.all', self::CACHE_DURATION, function () {
            return Game::all();
        });
    }

    /**
     * Store a newly created game.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|integer|min:1950|max:' . (date('Y') + 5),
            'publisher' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $game = Game::create($request->all());
        
        // Clear cache when creating a new game
        Cache::forget('games.all');
        
        return response()->json($game, 201);
    }

    /**
     * Display the specified game.
     */
    public function show(string $id)
    {
        return Cache::remember("games.{$id}", self::CACHE_DURATION, function () use ($id) {
            $game = Game::find($id);
            
            if (!$game) {
                return response()->json(['message' => 'Game not found'], 404);
            }
            
            return $game;
        });
    }

    /**
     * Update the specified game.
     */
    public function update(Request $request, string $id)
    {
        $game = Game::find($id);
        
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'image' => 'string',
            'description' => 'string',
            'genre' => 'string|max:100',
            'release_year' => 'integer|min:1950|max:' . (date('Y') + 5),
            'publisher' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $game->update($request->all());
        
        // Clear relevant caches
        Cache::forget('games.all');
        Cache::forget("games.{$id}");
        
        return response()->json($game);
    }

    /**
     * Remove the specified game.
     */
    public function destroy(string $id)
    {
        $game = Game::find($id);
        
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        
        $game->delete();
        
        // Clear relevant caches
        Cache::forget('games.all');
        Cache::forget("games.{$id}");
        
        return response()->json(['message' => 'Game deleted successfully']);
    }

    public function getByGenre(string $genre)
    {
        return Cache::remember("games.genre.{$genre}", self::CACHE_DURATION, function () use ($genre) {
            return Game::where('genre', $genre)->get();
        });
    }

    public function getByYear(int $year)
    {
        return Cache::remember("games.year.{$year}", self::CACHE_DURATION, function () use ($year) {
            return Game::where('release_year', $year)->get();
        });
    }
}