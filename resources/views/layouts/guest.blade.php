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
            
            .tableready-header {
                background-color: #28a745;
                color: white;
                padding: 1.5rem 0;
                text-align: center;
            }
            
            .tableready-logo {
                font-weight: bold;
                font-size: 2rem;
                color: white;
                margin-bottom: 1rem;
            }
            
            .tableready-logo span {
                color: #ffcc00;
            }
            
            .login-container {
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                max-width: 400px;
                margin: 0 auto;
            }
            
            .login-button {
                background-color: #28a745;
                color: white;
                font-weight: bold;
                padding: 0.75rem 1.5rem;
                border-radius: 0.25rem;
                width: 100%;
                text-align: center;
                margin-top: 1.5rem;
                border: none;
                cursor: pointer;
            }
            
            .login-button:hover {
                background-color: #218838;
            }
            
            .form-input {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #d1d5db;
                border-radius: 0.25rem;
                margin-top: 0.5rem;
            }
            
            .form-label {
                font-weight: 500;
                color: #374151;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col">
            <div class="tableready-header">
                <div class="tableready-logo">
                    table<span>ready</span>
                </div>
            </div>
            
            <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="login-container w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
