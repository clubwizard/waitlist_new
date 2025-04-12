<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TableReady') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .tableready-header {
                background-color: #28a745;
                color: white;
            }
            
            .tableready-logo {
                font-weight: bold;
                font-size: 1.5rem;
                color: white;
            }
            
            .tableready-logo span {
                color: #ffcc00;
            }
            
            .back-button {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1rem;
                background-color: white;
                color: #666;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            
            @media (max-width: 640px) {
                .mobile-waitlist-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem;
                }
                
                .mobile-back-button {
                    background-color: white;
                    color: #666;
                    border-radius: 9999px;
                    padding: 0.5rem 1rem;
                    font-size: 0.875rem;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- TableReady Header for Mobile -->
            <header class="tableready-header shadow-md md:hidden">
                <div class="container mx-auto px-4 py-3">
                    <div class="flex justify-between items-center">
                        <div class="tableready-logo">
                            <a href="{{ route('dashboard') }}">table<span>ready</span></a>
                        </div>
                        <button class="text-white focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow md:block hidden">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
