<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Dashboard</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        /* ── Main card ── */
        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .text-gray-700,
        .text-sm.font-medium { color: #9a8a6a !important; }
    </style>

    <div class="py-8 max-w-5xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">

        <p class="mb-6" style="color:#e8dfc8;">
            Welcome back, {{ auth()->user()->name }} —
            <span style="color:#D4AF37; font-weight:700;">{{ auth()->user()->credits }} credits</span> available.
        </p>

        <!-- {{-- Quick stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            
            
        </div> -->

        {{-- Quick actions --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
            <a href="{{ route('listings.index') }}" class="text-center px-3 py-3 rounded font-semibold text-sm"
                style="background-color:rgba(212,175,55,0.12); border:1.5px solid #D4AF37; color:#D4AF37;">
                Browse Listings
            </a>
            <a href="{{ route('listings.create') }}" class="text-center px-3 py-3 rounded font-semibold text-sm"
                style="background-color:rgba(212,175,55,0.12); border:1.5px solid #D4AF37; color:#D4AF37;">
                Post a Listing
            </a>
            <a href="{{ route('swap-requests.index') }}" class="text-center px-3 py-3 rounded font-semibold text-sm"
                style="background-color:rgba(212,175,55,0.12); border:1.5px solid #D4AF37; color:#D4AF37;">
                Swap Requests
            </a>
            <a href="{{ route('bookings.index') }}" class="text-center px-3 py-3 rounded font-semibold text-sm"
                style="background-color:rgba(212,175,55,0.12); border:1.5px solid #D4AF37; color:#D4AF37;">
                My Sessions
            </a>
        </div>

        {{-- Upcoming sessions preview --}}
        <div class="p-6 rounded" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
            <h3 class="font-semibold mb-3" style="color:#D4AF37;">Upcoming Sessions</h3>
           
            
        </div>

    </div>
</x-app-layout>