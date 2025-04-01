<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Str::limit($post->title, 50) }}
            </h2>
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                {{ __('Back to Posts') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($post->featured_image)
                    <div class="h-96 overflow-hidden">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full object-cover">
                    </div>
                @endif
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
                    <div class="flex items-center text-gray-600 mb-8">
                        <span>By {{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->created_at != $post->updated_at)
                            <span class="mx-2">•</span>
                            <span>Updated {{ $post->updated_at->format('M d, Y') }}</span>
                        @endif
                    </div>

                    <div class="prose max-w-none">
                        {{ $post->content }}
                    </div>

                    @can('update', $post)
                        <div class="mt-8 flex gap-4">
                            <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                {{ __('Edit Post') }}
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    {{ __('Delete Post') }}
                                </button>
                            </form>
                        </div>
                    @endcan

                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Comments</h3>
                        
                        @auth
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="block text-gray-700 mb-2">Add a comment</label>
                                    <textarea id="content" name="content" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" required></textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    {{ __('Submit Comment') }}
                                </button>
                            </form>
                        @else
                            <div class="mb-6 p-4 bg-gray-100 rounded">
                                <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a> to leave a comment.</p>
                            </div>
                        @endauth
                        
                        <div class="space-y-4">
                            @forelse ($post->comments as $comment)
                                <div class="bg-gray-50 p-4 rounded shadow-sm">
                                    <div class="flex justify-between">
                                        <div class="font-medium text-gray-800">{{ $comment->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="mt-2 text-gray-700">{{ $comment->content }}</div>
                                    
                                    @can('delete', $comment)
                                        <div class="mt-2 text-right">
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-sm hover:underline" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            @empty
                                <p class="text-gray-500">No comments yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>