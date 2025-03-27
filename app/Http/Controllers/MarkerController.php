<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        return view('map');
    }

    public function show()
    {
        $markers = Marker::all();
        return response()->json($markers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string'
        ]);

        $marker = Marker::create($validated);
        return response()->json($marker);
    }

    public function update(Request $request, Marker $marker)
    {
        // Log the before state
        \Log::debug('Original marker:', $marker->toArray());
        \Log::debug('Request data:', $request->all());
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $marker->update($validated);
        
        // Log the after state
        \Log::debug('Updated marker:', $marker->toArray());
        
        return response()->json($marker);
    }

    public function destroy(Marker $marker)
    {
        $marker->delete();
        return response()->json(['message' => 'Marker deleted']);
    }
}