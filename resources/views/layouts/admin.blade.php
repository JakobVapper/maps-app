<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Admin Theme -->
        <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
            
            .btn-primary {
                background-color: #FFD700 !important;
                color: #000000 !important;
                border: none !important;
                padding: 0.5rem 1rem !important;
                border-radius: 0.375rem !important;
                font-weight: 500 !important;
                transition: all 0.2s !important;
            }
            
            .btn-primary:hover {
                background-color: #FFC400 !important;
                transform: translateY(-2px) !important;
            }
            
            .page-header {
                color: #FFD700 !important;
                font-weight: 600 !important;
            }
            
            table {
                border-radius: 8px !important;
                overflow: hidden !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Admin Navigation -->
            <nav class="bg-indigo-800 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('admin.posts.index') }}" class="font-bold text-xl">
                                    {{ config('app.name') }} Admin
                                </a>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('admin.posts.*') ? 'border-b-2 border-white' : 'text-indigo-200' }}">
                                    Posts
                                </a>
                                <a href="{{ route('admin.users') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('admin.users') ? 'border-b-2 border-white' : 'text-indigo-200' }}">
                                    Users
                                </a>
                                <a href="{{ route('admin.comments') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 {{ request()->routeIs('admin.comments') ? 'border-b-2 border-white' : 'text-indigo-200' }}">
                                    Comments
                                </a>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-indigo-200">
                                    Back to Site
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="ml-3 relative">
                                <div class="flex items-center">
                                    <span class="text-sm">{{ Auth::user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}" class="ml-3">
                                        @csrf
                                        <button type="submit" class="text-sm text-indigo-200 hover:text-white">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>