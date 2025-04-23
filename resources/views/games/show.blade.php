.blade.php
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $game->title }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('games.index') }}" class="game-header-button dark inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Back to Games') }}
                </a>
                @auth
                <a href="{{ route('games.edit', $game->id) }}" class="game-header-button gold inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    {{ __('Edit Game') }}
                </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="game-success-message mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/3">
                    <div class="game-banner">
                        <img src="{{ asset($game->image) }}" alt="{{ $game->title }}">
                    </div>
                    
                    <div class="game-info-card">
                        <div class="flex items-center justify-between mb-3">
                            <div class="game-tag">{{ $game->genre }}</div>
                            <div class="game-publisher-badge">{{ $game->publisher ?? 'Unknown' }}</div>
                        </div>
                        
                        <div class="game-attribute-list mt-4">
                            <div class="game-attribute-item">
                                <div class="game-attribute-label">Release Year</div>
                                <div class="game-attribute-value">{{ $game->release_year }}</div>
                            </div>
                            <div class="game-attribute-item">
                                <div class="game-attribute-label">Added On</div>
                                <div class="game-attribute-value">{{ \Carbon\Carbon::parse($game->created_at)->format('F j, Y') }}</div>
                            </div>
                        </div>
                        
                        @auth
                        <div class="game-action-buttons">
                            <a href="{{ route('games.edit', $game->id) }}" class="w-1/2 inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit
                            </a>
                            
                            <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="w-1/2" onsubmit="return confirm('Are you sure you want to delete this game?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="game-delete-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
                
                <div class="md:w-2/3">
                    <div class="game-info-card h-full">
                        <h1 class="game-title-large">{{ $game->title }}</h1>
                        <div class="game-description">
                            <p>{{ $game->description }}</p>
                        </div>
                        
                        <div class="game-details-section">
                            <h3 class="game-details-title">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                About This Game
                            </h3>
                            <p class="text-gray-300 mb-6">Discover more about this incredible title that has captured gamers around the world. Featuring stunning graphics, immersive gameplay and an unforgettable story.</p>
                            
                            <h3 class="text-lg font-medium text-gray-200 mb-2">Key Features</h3>
                            <ul class="list-disc list-inside text-gray-300 mb-4 pl-4 space-y-1">
                                <li>Immersive {{ $game->genre }} experience</li>
                                <li>Published by {{ $game->publisher ?? 'an independent studio' }}</li>
                                <li>Originally released in {{ $game->release_year }}</li>
                                <li>Perfect for fans of the {{ $game->genre }} genre</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>