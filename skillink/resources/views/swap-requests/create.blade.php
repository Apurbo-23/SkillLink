<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Request a Swap</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

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

        <div class="mb-4 p-4 rounded-lg border" style="background-color: #121110; border-color: #D4AF37;">
            <p style="color: #e8dfc8;">
                <span style="color:#D4AF37; font-weight:600;">{{ $listing->skill_offered }}</span>
                for <span style="color:#D4AF37; font-weight:600;">{{ $listing->skill_wanted }}</span>
                &mdash; offered by {{ $listing->user->name }}
            </p>
        </div>

        <form method="POST" action="{{ route('swap-requests.store', $listing) }}" class="space-y-4 p-6 rounded-lg border" style="background-color: #121110; border-color: #D4AF37;">
            @csrf

            <div>
                <label class="block font-medium text-sm" style="color: #D4AF37;">Message to {{ $listing->user->name }}</label>
                <textarea name="message" rows="4" required
                    class="mt-1 block w-full rounded border" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;"
                    placeholder="Introduce yourself and explain what you'd like to swap...">{{ old('message') }}</textarea>
            </div>

            <p class="text-sm" style="color: #9a8a6a;">
                Sending this request holds <span style="color:#D4AF37; font-weight:600;">{{ $cost }} credits</span>
                from your balance. They're refunded if the request is declined or cancelled, and released to
                {{ $listing->user->name }} once the swap is completed.
            </p>

            <button type="submit" class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">
                Send Swap Request
            </button>
        </form>
    </div>
</x-app-layout>
