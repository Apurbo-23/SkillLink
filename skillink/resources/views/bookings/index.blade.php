<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">My Sessions</h2>
    </x-slot>
<style>
        /* ── Base page background ── */
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
        @if (session('success'))
            <div class="mb-4 p-4 rounded" style="background-color: #1a1814; color: #D4AF37; border: 1px solid rgba(212,175,55,0.25);">{{ session('success') }}</div>
        @endif

        <a href="{{ route('bookings.create') }}" class="inline-block mb-6 px-4 py-2 rounded font-semibold text-sm" style="background-color: #D4AF37; color: #0B0A09;">
            + Book a Session
        </a>

        <div class="overflow-hidden rounded-lg border" style="border-color: #D4AF37; background-color: #121110;">
            <table class="w-full" style="border-collapse: collapse; color: #e8dfc8;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(212,175,55,0.25); background-color: #0B0A09;">
                        <th class="p-3 text-left" style="color: #D4AF37;">With</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">When</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Duration</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Status</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr style="border-bottom: 1px solid rgba(212,175,55,0.16);">
                            <td class="p-3">
                                {{ $booking->requester_id === auth()->id() ? $booking->provider->name : $booking->requester->name }}
                            </td>
                            <td class="p-3">{{ $booking->scheduled_at->format('M d, Y g:i A') }}</td>
                            <td class="p-3">{{ $booking->duration_minutes }} min</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs rounded" style="border: 1px solid rgba(212,175,55,0.25); background-color: #0B0A09; color: #D4AF37;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="p-3 space-x-2">
                                @if ($booking->status === 'pending' && $booking->provider_id === auth()->id())
                                    <form method="POST" action="{{ route('bookings.status', $booking) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Confirm</button>
                                    </form>
                                @endif
                                @if ($booking->status !== 'cancelled')
                                    <form method="POST" action="{{ route('bookings.status', $booking) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button style="color:#f5b7b1; font-weight:600;" class="text-sm">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center" style="color: #9a8a6a;">No sessions booked yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>