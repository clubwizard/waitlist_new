<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ __('Restaurant Details') }}</h3>
                        <div>
                            <a href="{{ route('restaurants.edit', $restaurant) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Edit') }}
                            </a>
                             <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2">Basic Information</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $restaurant->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="mt-1 text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $restaurant->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $restaurant->active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </dd>
                                </div>
                                @if($restaurant->logo_path)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Logo</dt>
                                    <dd class="mt-1">
                                        <img src="{{ asset('storage/' . $restaurant->logo_path) }}" alt="{{ $restaurant->name }} Logo" class="h-20 w-auto rounded">
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2">Contact & Location</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $restaurant->address }}<br>
                                        {{ $restaurant->city }}, {{ $restaurant->state }} {{ $restaurant->zip }}<br>
                                        {{ $restaurant->country }}
                                    </dd>
                                </div>
                                 <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $restaurant->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $restaurant->email }}</dd>
                                </div>
                                @if($restaurant->website)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Website</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white"><a href="{{ $restaurant->website }}" target="_blank" class="text-green-600 hover:underline">{{ $restaurant->website }}</a></dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Timezone</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $restaurant->timezone }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Placeholder for other sections like Settings, Waitlist, etc. --}}
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                         <h4 class="font-semibold mb-2">Additional Details</h4>
                         <p class="text-sm text-gray-600 dark:text-gray-400">Further details and settings for this restaurant will be displayed here.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
