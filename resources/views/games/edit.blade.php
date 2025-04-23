<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Game') }}: {{ $game->title }}
            </h2>
            <a href="{{ route('games.show', $game->id) }}" class="game-header-button dark inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                {{ __('Back to Game') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="game-form">
                @if ($errors->any())
                    <div class="game-error-message mb-6" role="alert">
                        <strong class="font-bold">Oops! There were some problems with your input.</strong>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="game-form-title">Update Game Information</h2>

                <form action="{{ route('games.update', $game->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="game-form-grid">
                        <div class="game-form-field">
                            <label for="title" class="game-form-label">Title</label>
                            <input id="title" type="text" class="game-form-input" name="title" value="{{ old('title', $game->title) }}" required autofocus>
                        </div>
                        
                        <div class="game-form-field">
                            <label for="image" class="game-form-label">Image URL</label>
                            <input id="image" type="text" class="game-form-input" name="image" value="{{ old('image', $game->image) }}" required>
                            <p class="text-xs text-gray-500 mt-1">Enter a full URL to an image, e.g. https://example.com/image.jpg</p>
                        </div>
                        
                        <div class="game-form-field">
                            <label for="genre" class="game-form-label">Genre</label>
                            <input id="genre" type="text" class="game-form-input" name="genre" value="{{ old('genre', $game->genre) }}" required>
                        </div>
                        
                        <div class="game-form-field">
                            <label for="release_year" class="game-form-label">Release Year</label>
                            <input id="release_year" type="number" min="1950" max="{{ date('Y') + 5 }}" class="game-form-input" name="release_year" value="{{ old('release_year', $game->release_year) }}" required>
                        </div>
                        
                        <div class="game-form-field">
                            <label for="publisher" class="game-form-label">Publisher</label>
                            <input id="publisher" type="text" class="game-form-input" name="publisher" value="{{ old('publisher', $game->publisher) }}">
                        </div>
                        
                        <div class="game-form-field full-width">
                            <label for="description" class="game-form-label">Description</label>
                            <textarea id="description" class="game-form-input game-form-textarea" name="description" rows="6" required>{{ old('description', $game->description) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="game-form-submit">
                            {{ __('Update Game') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>