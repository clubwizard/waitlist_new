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
            body {
                font-family: 'Poppins', sans-serif;
            }
            
            /* TableReady Branding */
            .tableready-header {
                background-color: #28a745;
                color: white;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            }
            
            .tableready-logo {
                font-weight: bold;
                font-size: 1.5rem;
                color: white;
                transition: transform 0.2s ease;
            }
            
            .tableready-logo:hover {
                transform: scale(1.02);
            }
            
            .tableready-logo span {
                background: linear-gradient(90deg, #ff7f00, #ffcc00);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            
            /* Apple-style UI Elements */
            .back-button {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1rem;
                background-color: white;
                color: #666;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                transition: all 0.2s ease;
            }
            
            .back-button:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            }
            
            /* Card Styling */
            .card {
                background-color: white;
                border-radius: 0.85rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                overflow: hidden;
            }
            
            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }
            
            /* Status Cards */
            .status-card {
                padding: 1.5rem;
                text-align: center;
                border-radius: 0.85rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
                transition: all 0.2s ease;
            }
            
            .status-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.12);
            }
            
            .status-card .count {
                font-size: 3rem;
                font-weight: 700;
                line-height: 1;
            }
            
            .status-card .label {
                font-size: 1.125rem;
                font-weight: 500;
                margin-bottom: 0.5rem;
            }
            
            .status-card.waiting {
                background-color: #28a745;
                color: white;
            }
            
            .status-card.notified {
                background-color: #4299e1;
                color: white;
            }
            
            .status-card.seated {
                background-color: #28a745;
                color: white;
            }
            
            .status-card.cancelled {
                background-color: #f56565;
                color: white;
            }
            
            /* Button Styling */
            .btn {
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                font-weight: 500;
                transition: all 0.2s ease;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }
            
            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            }
            
            .btn:active {
                transform: translateY(1px);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }
            
            .btn-primary {
                background-color: #28a745;
                color: white;
            }
            
            .btn-primary:hover {
                background-color: #218838;
            }
            
            /* Mobile Specific Styles */
            @media (max-width: 640px) {
                .mobile-waitlist-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem;
                    background-color: white;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                }
                
                .mobile-back-button {
                    background-color: white;
                    color: #666;
                    border-radius: 9999px;
                    padding: 0.5rem 1rem;
                    font-size: 0.875rem;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                    transition: all 0.2s ease;
                }
                
                .mobile-back-button:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
                }
            }
            
            /* Table Styling */
            .table-container {
                border-radius: 0.85rem;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            }
            
            /* Form Styling */
            .form-input {
                border-radius: 0.5rem;
                transition: all 0.2s ease;
                border: 1px solid #e2e8f0;
            }
            
            .form-input:focus {
                border-color: #28a745;
                box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
                outline: none;
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
