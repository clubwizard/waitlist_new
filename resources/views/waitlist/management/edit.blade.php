<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Waitlist Entry: {{ $entry->name }}
        </h2>
    </x-slot>
    
    <!-- Mobile Header with Back Button (Mobile Only) -->
    <div class="md:hidden mobile-waitlist-header bg-white shadow-sm">
        <h1 class="text-xl font-bold">Edit Waitlist Entry</h1>
        <a href="{{ route('restaurants.waitlist.index', $restaurant) }}" class="mobile-back-button">
            Back to Waitlist
        </a>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <!-- Back Button (Desktop Only) -->
            <a href="{{ route('restaurants.waitlist.index', $restaurant) }}" class="back-button mr-4 hidden md:flex">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Waitlist
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Waitlist Entry</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6">
            <form action="{{ route('waitlist.entries.update', $entry) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $entry->name) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                    <div class="flex mt-1">
                        <select name="country_code" id="country_code" class="rounded-l-md border-r-0 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="+1" {{ Str::startsWith($entry->phone_number, '+1') ? 'selected' : '' }}>+1 (US)</option>
                            <option value="+44" {{ Str::startsWith($entry->phone_number, '+44') ? 'selected' : '' }}>+44 (UK)</option>
                            <option value="+33" {{ Str::startsWith($entry->phone_number, '+33') ? 'selected' : '' }}>+33 (FR)</option>
                            <option value="+49" {{ Str::startsWith($entry->phone_number, '+49') ? 'selected' : '' }}>+49 (DE)</option>
                            <option value="+61" {{ Str::startsWith($entry->phone_number, '+61') ? 'selected' : '' }}>+61 (AU)</option>
                            <option value="+86" {{ Str::startsWith($entry->phone_number, '+86') ? 'selected' : '' }}>+86 (CN)</option>
                            <option value="+91" {{ Str::startsWith($entry->phone_number, '+91') ? 'selected' : '' }}>+91 (IN)</option>
                        </select>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', Str::replaceFirst('+1', '', Str::replaceFirst('+44', '', Str::replaceFirst('+33', '', Str::replaceFirst('+49', '', Str::replaceFirst('+61', '', Str::replaceFirst('+86', '', Str::replaceFirst('+91', '', $entry->phone_number)))))))) }}" required
                               class="flex-1 rounded-r-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               placeholder="(XXX) XXX-XXXX">
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (Optional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $entry->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="party_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Party Size</label>
                    <input type="number" name="party_size" id="party_size" value="{{ old('party_size', $entry->party_size) }}" required min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('party_size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="estimated_wait_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Wait Time (minutes)</label>
                    <input type="number" name="estimated_wait_time" id="estimated_wait_time" value="{{ old('estimated_wait_time', $entry->estimated_wait_time) }}" min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('estimated_wait_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $entry->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('restaurants.waitlist.index', $restaurant) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
