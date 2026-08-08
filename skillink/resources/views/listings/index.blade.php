<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Browse Listings</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('listings.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Post a Listing
        </a>

        <div class="space-y-4">
            @forelse ($listings as $listing)
                <div class="bg-white p-4 rounded shadow">
                    <p class="font-semibold">{{ $listing->skill_offered }} ↔ {{ $listing->skill_wanted }}</p>
                    <p class="text-sm text-gray-500">{{ $listing->category }} · posted by {{ $listing->user->name }}</p>
                    @if ($listing->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $listing->description }}</p>
                    @endif

                    @if ($listing->user_id !== auth()->id())
                        <a href="{{ route('swap-requests.create', $listing) }}" class="inline-block mt-2 text-sm text-indigo-600 underline">
                            Request Swap
                        </a>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">No listings yet. Be the first to post one!</p>
            @endforelse
        </div>
    </div>
</x-app-layout>