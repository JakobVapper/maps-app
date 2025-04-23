<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameViewController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }
    
    public function show($id)
    {
        // Access database directly
        $game = Game::findOrFail($id);
        return view('games.show', compact('game'));
    }
    
    public function create()
    {
        return view('games.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|integer|min:1950|max:' . (date('Y') + 5),
            'publisher' => 'nullable|string|max:255',
        ]);

        // Create game directly
        $game = Game::create($request->all());
        
        return redirect()->route('games.index')->with('success', 'Game created successfully!');
    }
    
    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('games.edit', compact('game'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:255',
            'image' => 'string',
            'description' => 'string',
            'genre' => 'string|max:100',
            'release_year' => 'integer|min:1950|max:' . (date('Y') + 5),
            'publisher' => 'nullable|string|max:255',
        ]);

        $game = Game::findOrFail($id);
        $game->update($request->all());
        
        return redirect()->route('games.show', $id)->with('success', 'Game updated successfully!');
    }
    
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        
        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }
}