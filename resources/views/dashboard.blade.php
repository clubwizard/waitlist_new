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
                    <div class="mb-8 card p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ $restaurant->name }} - Waitlist Dashboard</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Waiting Count -->
                            <div class="status-card waiting">
                                <h3 class="label">Waiting</h3>
                                <p class="count">
                                    {{ $restaurant->waitlistEntries()->where('status', 'pending')->count() }}
                                </p>
                            </div>
                            
                            <!-- Notified Count -->
                            <div class="status-card notified">
                                <h3 class="label">Notified</h3>
                                <p class="count">
                                    {{ $restaurant->waitlistEntries()->where('status', 'notified')->count() }}
                                </p>
                            </div>
                            
                            <!-- Seated Today Count -->
                            <div class="status-card seated">
                                <h3 class="label">Seated Today</h3>
                                <p class="count">
                                    {{ $restaurant->waitlistEntries()
                                        ->where('status', 'seated')
                                        ->whereDate('seated_at', today())
                                        ->count() }}
                                </p>
                            </div>
                            
                            <!-- Cancelled Today Count -->
                            <div class="status-card cancelled">
                                <h3 class="label">Cancelled Today</h3>
                                <p class="count">
                                    {{ $restaurant->waitlistEntries()
                                        ->where('status', 'cancelled')
                                        ->whereDate('updated_at', today())
                                        ->count() }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-right">
                            <a href="{{ route('restaurants.waitlist.index', $restaurant) }}" 
                               class="btn btn-primary inline-flex items-center">
                                <span>Manage Waitlist</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card p-6">
                    <div class="p-6 text-gray-700">
                        <p>You don't have any restaurants set up yet.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
