<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Swap Request #{{ $swapRequest->id }}</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
    </style>

    <div class="py-8 max-w-xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">
        @if (session('success'))
            <div class="mb-4 p-4 rounded" style="background-color: #1a1814; color: #D4AF37; border: 1px solid rgba(212,175,55,0.25);">{{ session('success') }}</div>
        @endif

        @include('swap-requests.partials.progress-tracker')

        <div class="p-6 rounded-lg border space-y-4" style="background-color: #121110; border-color: #D4AF37; color: #e8dfc8;">
            <div>
                <span style="color:#9a8a6a;">Listing:</span>
                {{ $swapRequest->listing->skill_offered }} for {{ $swapRequest->listing->skill_wanted }}
            </div>
            <div><span style="color:#9a8a6a;">Requester:</span> {{ $swapRequest->requester->name }}</div>
            <div><span style="color:#9a8a6a;">Provider:</span> {{ $swapRequest->provider->name }}</div>
            <div><span style="color:#9a8a6a;">Credits held:</span> {{ $swapRequest->credits_amount }}</div>
            <div><span style="color:#9a8a6a;">Status:</span> <span style="color:#D4AF37; font-weight:600;">{{ $swapRequest->stageLabel() }}</span></div>
            <div>
                <span style="color:#9a8a6a;">Message:</span>
                <p class="mt-1 p-3 rounded" style="background-color:#0B0A09; border:1px solid rgba(212,175,55,0.16);">{{ $swapRequest->message }}</p>
            </div>

            <div class="flex gap-2 pt-2">
                @if ($swapRequest->status === 'pending' && auth()->id() === $swapRequest->provider_id)
                    <form method="POST" action="{{ route('swap-requests.accept', $swapRequest) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('swap-requests.reject', $swapRequest) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 rounded font-semibold border" style="border-color:#f5b7b1; color:#f5b7b1;">Decline</button>
                    </form>
                @endif

                @if ($swapRequest->status === 'pending' && auth()->id() === $swapRequest->requester_id)
                    <form method="POST" action="{{ route('swap-requests.cancel', $swapRequest) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 rounded font-semibold border" style="border-color:#f5b7b1; color:#f5b7b1;">Cancel Request</button>
                    </form>
                @endif

                @if ($swapRequest->status === 'accepted')
                    <form method="POST" action="{{ route('swap-requests.start', $swapRequest) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">Start Swap</button>
                    </form>
                @endif

                @if ($swapRequest->status === 'in_progress')
                    <form method="POST" action="{{ route('swap-requests.complete', $swapRequest) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">Mark Completed</button>
                    </form>
                @endif
            </div>
        </div>

        @include('swap-requests.partials.chat')
    </div>
</x-app-layout>
