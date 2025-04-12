<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->restaurants->count() > 0)
                @foreach(auth()->user()->restaurants as $restaurant)
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-4">{{ $restaurant->name }} - Waitlist Dashboard</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Waiting Count -->
                            <div class="bg-green-600 text-white p-6 rounded-lg shadow-md text-center">
                                <h3 class="text-lg font-semibold mb-2">Waiting</h3>
                                <p class="text-3xl font-bold">
                                    {{ $restaurant->waitlistEntries()->where('status', 'pending')->count() }}
                                </p>
                            </div>
                            
                            <!-- Notified Count -->
                            <div class="bg-blue-400 text-white p-6 rounded-lg shadow-md text-center">
                                <h3 class="text-lg font-semibold mb-2">Notified</h3>
                                <p class="text-3xl font-bold">
                                    {{ $restaurant->waitlistEntries()->where('status', 'notified')->count() }}
                                </p>
                            </div>
                            
                            <!-- Seated Today Count -->
                            <div class="bg-green-700 text-white p-6 rounded-lg shadow-md text-center">
                                <h3 class="text-lg font-semibold mb-2">Seated Today</h3>
                                <p class="text-3xl font-bold">
                                    {{ $restaurant->waitlistEntries()
                                        ->where('status', 'seated')
                                        ->whereDate('seated_at', today())
                                        ->count() }}
                                </p>
                            </div>
                            
                            <!-- Cancelled Today Count -->
                            <div class="bg-red-500 text-white p-6 rounded-lg shadow-md text-center">
                                <h3 class="text-lg font-semibold mb-2">Cancelled Today</h3>
                                <p class="text-3xl font-bold">
                                    {{ $restaurant->waitlistEntries()
                                        ->where('status', 'cancelled')
                                        ->whereDate('updated_at', today())
                                        ->count() }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <a href="{{ route('restaurants.waitlist.index', $restaurant) }}" 
                               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg">
                                Manage Waitlist
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>You don't have any restaurants set up yet.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
