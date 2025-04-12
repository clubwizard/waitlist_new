<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Join Waitlist - {{ $restaurant->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles for Apple-style UI -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0a1a1a; /* Dark green/black background */
            color: #ffffff; /* White text */
        }
        
        .form-container {
            background-color: rgba(42, 59, 59, 0.8); /* Slightly transparent dark shade for form */
            backdrop-filter: blur(10px); /* Apple-style frosted glass effect */
            -webkit-backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            margin-top: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); /* Apple-style shadow */
        }
        
        .form-input {
            background-color: rgba(42, 59, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
            outline: none;
        }
        
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-button {
            background-color: #28a745; /* TableReady Green */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-button:hover {
            background-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .form-button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .restaurant-logo {
            max-height: 60px;
            width: auto;
            margin-bottom: 1.5rem;
        }
        
        .tableready-header {
            text-align: center;
            padding: 2rem 0 1rem;
        }
        
        .tableready-logo {
            font-weight: bold;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .tableready-logo span {
            color: #ffcc00; /* TableReady Yellow */
        }
        
        .success-message {
            background-color: rgba(40, 167, 69, 0.1);
            color: #4CAF50;
            padding: 1rem;
            border-left: 4px solid #4CAF50;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }
        
        .error-message {
            color: #f56565; /* Red for errors */
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        /* Apple-style animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        <div class="tableready-header">
            <div class="tableready-logo">
                table<span>ready</span>
            </div>
            <h1 class="text-2xl font-medium text-center mb-2">{{ $restaurant->name }}</h1>
        </div>

        <div class="form-container w-full sm:max-w-md mt-6 px-6 py-8 shadow-md overflow-hidden">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-2xl font-semibold text-center mb-6">Join the Waitlist</h2>

            <form method="POST" action="{{ url('/waitlist/' . $restaurant->slug) }}" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Party Size -->
                <div class="mb-6">
                    <label for="party_size" class="form-label">{{ __('Party Size') }}</label>
                    <input id="party_size" class="block w-full form-input"
                           type="number" name="party_size" value="{{ old('party_size') }}" required autofocus min="1" />
                     @error('party_size')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="form-label">{{ __('Full Name') }}</label>
                    <input id="name" class="block w-full form-input"
                           type="text" name="name" value="{{ old('name') }}" required />
                     @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-6">
                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                    <div class="flex">
                        <select name="country_code" class="form-input rounded-l-md" style="width: 100px; border-right: none; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <option value="+1" {{ old('country_code', '+1') == '+1' ? 'selected' : '' }}>+1 (US)</option>
                            <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                            <option value="+61" {{ old('country_code') == '+61' ? 'selected' : '' }}>+61 (AU)</option>
                            <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                            <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49 (DE)</option>
                            <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>+971 (UAE)</option>
                        </select>
                        <input id="phone" class="block w-full form-input rounded-r-md" style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                               type="tel" name="phone" value="{{ old('phone') }}" required placeholder="(XXX) XXX-XXXX" />
                    </div>
                    @error('phone')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Optional) -->
                <div class="mb-6">
                    <label for="email" class="form-label">{{ __('Email (Optional)') }}</label>
                    <input id="email" class="block w-full form-input"
                           type="email" name="email" value="{{ old('email') }}" />
                     @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Notes (Optional) -->
                <div class="mb-8">
                    <label for="notes" class="form-label">{{ __('Notes (Optional)') }}</label>
                    <textarea id="notes" name="notes" rows="3" class="block w-full form-input" placeholder="e.g., High chair needed, birthday celebration">{{ old('notes') }}</textarea>
                     @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="form-button w-full py-3 text-lg">
                        {{ __('JOIN WAITLIST') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
