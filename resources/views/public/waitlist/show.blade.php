<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Join Waitlist - {{ $restaurant->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles for Dark Theme -->
    <style>
        body {
            background-color: #0a1a1a; /* Dark green/black background */
            color: #ffffff; /* White text */
        }
        .form-container {
            background-color: #1a2b2b; /* Slightly lighter dark shade for form */
            border-radius: 0.5rem;
            padding: 2rem;
            margin-top: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-input {
            background-color: #2a3b3b;
            border: 1px solid #4a5b5b;
            color: #ffffff;
        }
        .form-input::placeholder {
            color: #a0aec0;
        }
        .form-label {
            color: #cbd5e0;
        }
        .form-button {
            background-color: #4CAF50; /* Primary Green */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease;
        }
        .form-button:hover {
            background-color: #45a049;
        }
        .restaurant-logo {
            max-height: 60px;
            width: auto;
            margin-bottom: 1.5rem;
        }
        .success-message {
            background-color: #2a3b3b;
            color: #4CAF50;
            padding: 1rem;
            border-left: 4px solid #4CAF50;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
        }
         .error-message {
            color: #f56565; /* Red for errors */
            font-size: 0.875rem; /* text-sm */
            margin-top: 0.25rem; /* mt-1 */
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        <div>
            @if($restaurant->logo_path)
                <img src="{{ asset('storage/' . $restaurant->logo_path) }}" alt="{{ $restaurant->name }} Logo" class="restaurant-logo">
            @else
                <h1 class="text-3xl font-bold text-center mb-6">{{ $restaurant->name }}</h1>
            @endif
        </div>

        <div class="form-container w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

             @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-2xl font-semibold text-center mb-6">Join the Waitlist</h2>

            {{-- TODO: Implement multi-step form later --}}
            <form method="POST" action="{{ route('public.waitlist.store', $restaurant->slug) }}">
                @csrf

                <!-- Party Size -->
                <div class="mb-4">
                    <label for="party_size" class="block form-label text-sm font-medium">{{ __('Party Size') }}</label>
                    <input id="party_size" class="block mt-1 w-full form-input rounded-md shadow-sm"
                           type="number" name="party_size" value="{{ old('party_size') }}" required autofocus min="1" />
                     @error('party_size')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block form-label text-sm font-medium">{{ __('Full Name') }}</label>
                    <input id="name" class="block mt-1 w-full form-input rounded-md shadow-sm"
                           type="text" name="name" value="{{ old('name') }}" required />
                     @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone" class="block form-label text-sm font-medium">{{ __('Phone Number') }}</label>
                    {{-- TODO: Add country code dropdown --}}
                    <input id="phone" class="block mt-1 w-full form-input rounded-md shadow-sm"
                           type="tel" name="phone" value="{{ old('phone') }}" required />
                     @error('phone')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Optional) -->
                <div class="mb-4">
                    <label for="email" class="block form-label text-sm font-medium">{{ __('Email (Optional)') }}</label>
                    <input id="email" class="block mt-1 w-full form-input rounded-md shadow-sm"
                           type="email" name="email" value="{{ old('email') }}" />
                     @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Notes (Optional) -->
                <div class="mb-6">
                    <label for="notes" class="block form-label text-sm font-medium">{{ __('Notes (Optional)') }}</label>
                    <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full form-input rounded-md shadow-sm" placeholder="e.g., High chair needed, birthday celebration">{{ old('notes') }}</textarea>
                     @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="form-button">
                        {{ __('Join Waitlist') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
