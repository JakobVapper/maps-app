<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Post') }}
            </h2>
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                {{ __('Back to Posts') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title', $post->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="content" :value="__('Content')" />
                    <textarea id="content" name="content" rows="10" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('content', $post->content) }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <p class="text-gray-700 mb-2">Author: {{ $post->user->name }} ({{ $post->user->email }})</p>
                </div>

                @if ($post->featured_image)
                    <div class="mb-4">
                        <p class="mb-2">Current Featured Image:</p>
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current Featured Image" class="h-48 object-contain">
                    </div>
                @endif

                <div class="mb-4">
                    <x-input-label for="featured_image" :value="__('Featured Image (Optional)')" />
                    <input type="file" id="featured_image" name="featured_image" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100">
                    <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Update Post') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>