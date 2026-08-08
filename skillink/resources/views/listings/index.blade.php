<<<<<<< HEAD
=======

>>>>>>> ada177ada1a6e864f77558e92bfb58b03645f664
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Browse Listings</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .text-gray-700,
        .text-sm.font-medium { color: #7b6e55 !important; }
        .btn-text { color: #1c1b19 !important; font-size: 1rem;}
    </style>

    <div class="py-8 max-w-4xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">
        @if (session('success'))
            <div class="mb-4 p-4 rounded" style="background-color:#1a1814; color:#D4AF37; border:1px solid rgba(212,175,55,0.25);">
                {{ session('success') }}
            </div>
        @endif

<<<<<<< HEAD
        <a href="{{ route('listings.create') }}" class="inline-block mb-6 px-4 py-2 rounded font-semibold text-sm"
            style="background-color: #D4AF37; color: #0B0A09;">
=======
        <a href="{{ route('listings.create') }}" class="inline-block mb-6 px-3 py-2 rounded font-semibold btn-text" style="background-color: #D4AF37; color: #0B0A09;">
>>>>>>> ada177ada1a6e864f77558e92bfb58b03645f664
            + Post a Listing
        </a>

        <div class="space-y-4">
            @forelse ($listings as $listing)
                <div class="p-4 rounded" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
                    <p class="font-semibold" style="color:#e8dfc8;">
                        {{ $listing->skill_offered }} <span style="color:#D4AF37;">↔</span> {{ $listing->skill_wanted }}
                    </p>
                    <p class="text-sm mt-1" style="color:#9a8a6a;">
                        {{ $listing->category }} · posted by {{ $listing->user->name }}
                    </p>
                    @if ($listing->description)
                        <p class="text-sm mt-2" style="color:#c9bd9a;">{{ $listing->description }}</p>
                    @endif

                    @if ($listing->user_id !== auth()->id())
                        <a href="{{ route('swap-requests.create', $listing) }}"
                            class="inline-block mt-3 text-sm font-semibold"
                            style="color:#D4AF37;">
                            Request Swap →
                        </a>
                    @endif
                </div>
            @empty
                <p style="color:#9a8a6a;">No listings yet. Be the first to post one!</p>
            @endforelse
        </div>
    </div>
</x-app-layout>