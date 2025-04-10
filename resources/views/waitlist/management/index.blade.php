@extends('layouts.app') {{-- Assuming a main layout file exists --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Waitlist Management: {{ $restaurant->name }}</h1>
        {{-- Add button for manually adding entries later --}}
        {{-- <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Party</a> --}}
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
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
                    <tr>
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
                                <select name="status" onchange="this.form.submit()" class="text-sm rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="pending" {{ $entry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="seated" {{ $entry->status == 'seated' ? 'selected' : '' }}>Seated</option>
                                    <option value="cancelled" {{ $entry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="no_show" {{ $entry->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                                    {{-- Add 'notified' status later --}}
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{-- Add Notify button later --}}
                            {{-- <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">Notify</button> --}}
                            <form action="{{ route('waitlist.entries.destroy', $entry) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Remove</button>
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

    <div class="mt-4">
        {{ $waitlistEntries->links() }}
    </div>
</div>
@endsection
