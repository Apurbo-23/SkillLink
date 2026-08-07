<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Book a Session</h2>
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
    <div class="py-8 max-w-xl mx-auto" style="background-color: #0B0A09; min-height: 100vh;">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded" style="background-color: #1a1814; color: #f5b7b1; border: 1px solid rgba(212,175,55,0.25);">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4 p-6 rounded-lg border" style="background-color: #121110; border-color: #D4AF37;">
            @csrf

            <div>
                <label class="block font-medium text-sm" style="color: #D4AF37;">Book with</label>
                <select name="provider_id" required class="mt-1 block w-full rounded border" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;">
                    <option value="" style="background-color: #0B0A09; color: #e8dfc8;">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" style="background-color: #0B0A09; color: #e8dfc8;">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm" style="color: #D4AF37;">Date & Time</label>
                <input type="text" id="scheduled_at" name="scheduled_at" required
                    class="mt-1 block w-full rounded border" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;" placeholder="Pick a date & time" autocomplete="off">
            </div>

            <div>
                <label class="block font-medium text-sm" style="color: #D4AF37;">Duration</label>
                <select name="duration_minutes" required class="mt-1 block w-full rounded border" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;">
                    <option value="30" style="background-color: #0B0A09; color: #e8dfc8;">30 minutes</option>
                    <option value="60" selected style="background-color: #0B0A09; color: #e8dfc8;">60 minutes</option>
                    <option value="90" style="background-color: #0B0A09; color: #e8dfc8;">90 minutes</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm" style="color: #D4AF37;">Notes (optional)</label>
                <textarea name="notes" rows="3" class="mt-1 block w-full rounded border" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;"></textarea>
            </div>

            <button type="submit" class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">
                Confirm Booking
            </button>
        </form>
    </div>

    <!-- Flatpickr: lightweight calendar+time picker, no build step needed -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#scheduled_at", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            minuteIncrement: 15,
        });
    </script>
</x-app-layout>