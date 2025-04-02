<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Blog Theme -->
        <link href="{{ asset('css/blog-theme.css') }}" rel="stylesheet">
        
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
            
            .blog-header {
                color: #FFD700 !important;
                font-weight: 600 !important;
            }
            
            .post-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .post-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4) !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

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
                {{ $slot }}
            </main>
        </div>
    </body>
</html>