<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Waitlist Management: {{ $restaurant->name }}
        </h2>
    </x-slot>
    
    <!-- Mobile Header with Back Button (Mobile Only) -->
    <div class="md:hidden mobile-waitlist-header bg-tableready-green text-white shadow-apple-md flex justify-between items-center px-4 py-3">
        <h1 class="text-xl font-bold">Main Waitlist - Waitlist Dashboard</h1>
        <a href="{{ route('dashboard') }}" class="mobile-back-button bg-white text-tableready-green px-3 py-1 rounded-full shadow-apple-sm flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Waitlists
        </a>
    </div>
    
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <!-- Back Button (Desktop Only) -->
            <a href="{{ route('dashboard') }}" class="back-button mr-4 hidden md:flex">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Waitlists
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Waitlist Management: {{ $restaurant->name }}</h1>
        </div>
        {{-- Add button for manually adding entries later --}}
        <a href="{{ route('restaurants.waitlist.create', $restaurant) }}" class="btn btn-primary inline-flex items-center px-4 py-2 rounded-md shadow-apple-sm hover:shadow-apple-md transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Party
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-tableready-green text-green-700 px-4 py-3 rounded-apple shadow-apple-sm mb-4 transition-all duration-300 animate-fadeIn" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-tableready-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="table-container bg-white dark:bg-gray-800 shadow-apple-md rounded-apple overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Party Size</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Est. Wait</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined At</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($waitlistEntries as $index => $entry)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $waitlistEntries->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $entry->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $entry->party_size }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $entry->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $entry->estimated_wait_time ?? 'N/A' }} min</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $entry->created_at->format('h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <form action="{{ route('waitlist.entries.updateStatus', $entry) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-input text-sm rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-tableready-green focus:ring focus:ring-tableready-green focus:ring-opacity-50 transition-all duration-200">
                                    <option value="pending" {{ $entry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="notified" {{ $entry->status == 'notified' ? 'selected' : '' }}>Notified</option>
                                    <option value="seated" {{ $entry->status == 'seated' ? 'selected' : '' }}>Seated</option>
                                    <option value="cancelled" {{ $entry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="no_show" {{ $entry->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('waitlist.entries.edit', $entry) }}" class="btn inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-all duration-200 mr-2">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('waitlist.entries.notify', $entry) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="btn inline-flex items-center px-3 py-1 bg-indigo-500 text-white text-sm rounded-md hover:bg-indigo-600 transition-all duration-200 mr-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    Notify
                                </button>
                            </form>
                            <form action="{{ route('waitlist.entries.destroy', $entry) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">The waitlist is currently empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <div class="pagination-container">
            {{ $waitlistEntries->links() }}
        </div>
    </div>
    
    <style>
        .pagination-container nav {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 0.85rem;
            overflow: hidden;
        }
        
        .pagination-container .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            background: white;
            border-radius: 0.85rem;
        }
        
        .pagination-container .pagination li {
            transition: all 0.2s ease;
        }
        
        .pagination-container .pagination li a,
        .pagination-container .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            color: #4a5568;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .pagination-container .pagination li.active span {
            background-color: #28a745;
            color: white;
        }
        
        .pagination-container .pagination li:not(.active):hover a {
            background-color: #f7fafc;
            transform: translateY(-1px);
        }
    </style>
</div>
</x-app-layout>
