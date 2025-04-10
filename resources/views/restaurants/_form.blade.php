@csrf
<div class="space-y-6">
    <!-- Restaurant Name -->
    <div>
        <x-input-label for="name" :value="__('Restaurant Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $restaurant->name ?? '')" required autofocus autocomplete="organization" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Address -->
    <div>
        <x-input-label for="address" :value="__('Address')" />
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $restaurant->address ?? '')" required autocomplete="street-address" />
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- City -->
        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $restaurant->city ?? '')" required autocomplete="address-level2" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <!-- State -->
        <div>
            <x-input-label for="state" :value="__('State / Province')" />
            <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $restaurant->state ?? '')" required autocomplete="address-level1" />
            <x-input-error class="mt-2" :messages="$errors->get('state')" />
        </div>

        <!-- Zip Code -->
        <div>
            <x-input-label for="zip" :value="__('Zip / Postal Code')" />
            <x-text-input id="zip" name="zip" type="text" class="mt-1 block w-full" :value="old('zip', $restaurant->zip ?? '')" required autocomplete="postal-code" />
            <x-input-error class="mt-2" :messages="$errors->get('zip')" />
        </div>
    </div>

    <!-- Country -->
    <div>
        <x-input-label for="country" :value="__('Country')" />
        {{-- TODO: Replace with a country dropdown --}}
        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $restaurant->country ?? '')" required autocomplete="country-name" />
        <x-input-error class="mt-2" :messages="$errors->get('country')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            {{-- TODO: Add country code dropdown --}}
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $restaurant->phone ?? '')" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Contact Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $restaurant->email ?? '')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
    </div>

    <!-- Website -->
    <div>
        <x-input-label for="website" :value="__('Website (Optional)')" />
        <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $restaurant->website ?? '')" placeholder="https://example.com" autocomplete="url" />
        <x-input-error class="mt-2" :messages="$errors->get('website')" />
    </div>

    <!-- Timezone -->
    <div>
        <x-input-label for="timezone" :value="__('Timezone')" />
        {{-- TODO: Replace with a timezone dropdown --}}
        <x-text-input id="timezone" name="timezone" type="text" class="mt-1 block w-full" :value="old('timezone', $restaurant->timezone ?? '')" required placeholder="e.g., America/New_York" />
        <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
    </div>

    <!-- Logo -->
    <div>
        <x-input-label for="logo" :value="__('Logo (Optional)')" />
        <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*" />
        <x-input-error class="mt-2" :messages="$errors->get('logo')" />
        @isset($restaurant)
            @if($restaurant->logo_path)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Current Logo:</p>
                    <img src="{{ asset('storage/' . $restaurant->logo_path) }}" alt="{{ $restaurant->name }} Logo" class="mt-2 h-20 w-auto rounded">
                </div>
            @endif
        @endisset
    </div>

     <!-- Active Status -->
    <div class="block mt-4">
        <label for="active" class="inline-flex items-center">
            <input id="active" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800" name="active" value="1" {{ old('active', isset($restaurant) && $restaurant->active) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Active Restaurant') }}</span>
        </label>
         <x-input-error class="mt-2" :messages="$errors->get('active')" />
    </div>

</div>

<div class="flex items-center justify-end mt-8">
    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
        {{ __('Cancel') }}
    </a>
    <x-primary-button>
        {{ isset($restaurant) ? __('Update Restaurant') : __('Create Restaurant') }}
    </x-primary-button>
</div>
