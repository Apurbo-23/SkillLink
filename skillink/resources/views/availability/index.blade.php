<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">My Availability</h2>
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

    <div class="py-8 max-w-xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">
        @if (session('success'))
            <div class="mb-4 p-3 rounded text-sm" style="background-color:#1a1814; color:#D4AF37; border:1px solid rgba(212,175,55,0.25);">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('availability.update') }}" class="p-6 rounded" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
            @csrf
            <p class="text-sm mb-4" style="color:#9a8a6a;">Select the days you're available for sessions:</p>

            <div class="space-y-2">
                @foreach ($days as $day)
                    <label class="flex items-center gap-3 p-2 rounded" style="background-color:#1a1814;">
                        <input type="checkbox" name="days[]" value="{{ $day }}"
                            {{ in_array($day, $selectedDays) ? 'checked' : '' }}
                            style="accent-color:#D4AF37;">
                        <span style="color:#e8dfc8;">{{ $day }}</span>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="mt-5 px-4 py-2 rounded font-semibold text-sm" style="background-color:#D4AF37; color:#0B0A09;">
                Save Availability
            </button>
        </form>
    </div>
</x-app-layout>