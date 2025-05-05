<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Games Collection') }}
            </h2>
            @auth
            <a href="{{ route('games.create') }}" class="game-header-button gold inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('Add New Game') }}
            </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="game-success-message mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($games as $game)
                    <div class="game-card">
                        <div class="game-card-image">
                            <img src="{{ asset($game->image) }}" alt="{{ $game->title }}">
                            @if($game->publisher)
                                <div class="game-badge">{{ $game->publisher }}</div>
                            @endif
                        </div>
                        <div class="game-card-content">
                            <h3 class="game-card-title">
                                {{ $game->title }} 
                                <span>{{ $game->release_year }}</span>
                            </h3>
                            <p class="game-card-description">{{ Str::limit($game->description, 120) }}</p>
                            <div class="game-meta">
                                <span class="game-tag">{{ $game->genre }}</span>
                                <a href="{{ route('games.show', $game->id) }}" class="game-view-link">
                                    Details
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
             
            <div class="mt-16 pt-8 border-t-4 border-yellow-500 dark:border-yellow-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                    <span class="inline-block bg-gradient-to-r from-yellow-500 to-yellow-300 text-black px-4 py-1 rounded-lg mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        External Subjects
                    </span>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                        (from hajusrakendus.tak22jasin.itmajakas.ee)
                    </span>
                </h2>
                
                @if(empty($subjects))
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-300">No subject data available from the external API.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($subjects as $subject)
                            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700 hover:border-yellow-500 transition-all">
                                <!-- Image section -->
                                @if(isset($subject['image']))
                                    <div class="w-full h-48 overflow-hidden">
                                        <img src="{{ $subject['image'] }}" alt="{{ $subject['name'] ?? 'Subject Image' }}" 
                                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                    </div>
                                @else
                                    <div class="w-full h-24 bg-gray-800 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Content section -->
                                <div class="p-5">
                                    <h3 class="font-bold text-lg text-yellow-500 mb-2">{{ $subject['name'] ?? 'Unnamed Subject' }}</h3>
                                    @if(isset($subject['description']))
                                        <p class="text-gray-300 text-sm mb-3">{{ Str::limit($subject['description'], 100) }}</p>
                                    @endif
                                    <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-700">
                                        @if(isset($subject['credits']))
                                            <span class="bg-yellow-900 text-yellow-300 text-xs px-2 py-1 rounded font-bold">
                                                Credits: {{ $subject['credits'] }}
                                            </span>
                                        @endif
                                        @if(isset($subject['id']))
                                            <span class="text-xs text-gray-500">#{{ $subject['id'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>