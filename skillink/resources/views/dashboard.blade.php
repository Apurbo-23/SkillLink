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
            @if (isset($upcomingSessions) && $upcomingSessions->isNotEmpty())
                <div class="overflow-hidden rounded-lg border" style="border-color: #D4AF37; background-color: #0B0A09;">
                    @foreach ($upcomingSessions as $session)
                        <div class="p-4 rounded" style="background-color:#0B0A09; border:1px solid rgb(212, 175, 55);">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div style="color:#c9bd9a; font-size:0.9rem;">With</div>
                                    <div style="color:#e8dfc8; font-weight:600;">
                                        {{ $session->requester_id === auth()->id() ? $session->provider->name : $session->requester->name }}
                                    </div>
                                </div>
                                <div>
                                    <div style="color:#c9bd9a; font-size:0.9rem;">When</div>
                                    <div style="color:#e8dfc8; font-weight:600;">{{ $session->scheduled_at->format('M d, Y g:i A') }}</div>
                                </div>
                                <div>
                                    <div style="color:#c9bd9a; font-size:0.9rem;">Duration</div>
                                    <div style="color:#e8dfc8; font-weight:600;">{{ $session->duration_minutes }} min</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color:#9a8a6a;">No upcoming confirmed sessions yet.</p>
            @endif
        </div>

        {{-- Swap request status preview --}}
        <div class="p-6 rounded mt-6" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
            <h3 class="font-semibold mb-3" style="color:#D4AF37;">Swap Status</h3>
            @if (isset($swapStatuses) && $swapStatuses->isNotEmpty())
                <div class="overflow-hidden rounded-lg border" style="border-color: #D4AF37; background-color: #0B0A09;">
                    <table class="w-full" style="border-collapse: collapse; color: #e8dfc8;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(212,175,55,0.25); background-color: #121110;">
                                <th class="p-3 text-left" style="color: #D4AF37;">User</th>
                                <th class="p-3 text-left" style="color: #D4AF37;">Listing</th>
                                <th class="p-3 text-left" style="color: #D4AF37;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($swapStatuses as $swapRequest)
                                <tr style="border-bottom: 1px solid rgba(212,175,55,0.16);">
                                    <td class="p-3">
                                        @if ($swapRequest->requester_id === auth()->id())
                                            {{ $swapRequest->provider->name }}
                                        @else
                                            {{ $swapRequest->requester->name }}
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        {{ $swapRequest->listing->skill_offered }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded" style="border: 1px solid rgba(212,175,55,0.25); background-color: #0B0A09; color: #D4AF37;">
                                            {{ $swapRequest->stageLabel() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color:#9a8a6a;">No swap status updates yet.</p>
            @endif
        </div>

    </div>
</x-app-layout>