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

        <!-- Dispute Section -->
        <div class="mt-6 p-6 rounded-lg border" style="background-color: #121110; border-color: #D4AF37; color: #e8dfc8;">
            <h3 style="color: #D4AF37; font-weight: 600; font-size: 1.125rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dispute Management
            </h3>

            <!-- Display existing disputes -->
            @if ($swapRequest->disputes->count() > 0)
                <div class="mb-6 space-y-3">
                    <div style="color: #9a8a6a; font-size: 0.875rem;">Dispute History:</div>
                    @foreach ($swapRequest->disputes as $dispute)
                        <div class="p-4 rounded-lg border-l-4" 
                            style="background-color: #1a1814; border-left-color: {{ $dispute->status === 'open' ? '#f5b7b1' : '#D4AF37' }}; border: 1px solid rgba(212, 175, 55, 0.15);">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <div style="color: #D4AF37; font-weight: 600;">Raised by: {{ $dispute->raisedBy->name }}</div>
                                    <div style="color: #9a8a6a; font-size: 0.875rem;">{{ $dispute->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold" 
                                    style="background-color: {{ $dispute->status === 'open' ? 'rgba(245, 183, 177, 0.2)' : 'rgba(212, 175, 55, 0.2)' }}; color: {{ $dispute->status === 'open' ? '#f5b7b1' : '#D4AF37' }};">
                                    {{ strtoupper($dispute->status) }}
                                </span>
                            </div>
                            <div style="color: #e8dfc8; margin: 0.75rem 0;">{{ $dispute->reason }}</div>
                            @if ($dispute->admin_notes)
                                <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(212, 175, 55, 0.15);">
                                    <div style="color: #9a8a6a; font-size: 0.875rem;">Admin Notes:</div>
                                    <div style="color: #e8dfc8; margin-top: 0.25rem;">{{ $dispute->admin_notes }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Raise Dispute Form -->
            @if (!$swapRequest->disputes()->where('status', 'open')->exists())
                <div style="background-color: #1a1814; border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 0.375rem; padding: 1.25rem;">
                    <div style="color: #9a8a6a; font-size: 0.875rem; margin-bottom: 1rem;">
                        If you encounter any issues with this swap, you can raise a dispute for admin review. Provide a clear description of the issue.
                    </div>

                    <form method="POST" action="{{ route('disputes.store', $swapRequest) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" style="display: block; color: #9a8a6a; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                Describe the Issue <span style="color: #f5b7b1;">*</span>
                            </label>
                            <textarea 
                                id="reason"
                                name="reason" 
                                rows="4" 
                                required 
                                placeholder="Explain what went wrong..."
                                style="background-color: #0B0A09; border: 1px solid {{ $errors->has('reason') ? '#f5b7b1' : 'rgba(212, 175, 55, 0.25)' }}; color: #e8dfc8; border-radius: 0.375rem; width: 100%; padding: 0.75rem; font-family: inherit; resize: vertical;"
                            ></textarea>
                            @error('reason')
                                <div style="color: #f5b7b1; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button 
                            type="submit" 
                            class="px-4 py-2 rounded font-semibold transition ease-in-out"
                            style="background-color: #D4AF37; color: #0B0A09; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#e8c13f'"
                            onmouseout="this.style.backgroundColor='#D4AF37'"
                        >
                             Raise Dispute
                        </button>
                        <span style="color: #9a8a6a; font-size: 0.875rem; margin-left: 1rem;">
                            An admin will review and help resolve the issue
                        </span>
                    </form>
                </div>
            @else
                <div style="background-color: #1a1814; border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 0.375rem; padding: 1rem; display: flex; align-items: center; gap: 1rem;">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #D4AF37;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div>
                        <div style="color: #D4AF37; font-weight: 600;">Dispute Already Raised</div>
                        <div style="color: #9a8a6a; font-size: 0.875rem;">An admin is currently reviewing this dispute. You'll receive updates as it progresses.</div>
                    </div>
                </div>
            @endif
        </div>

        @include('swap-requests.partials.chat')
    </div>
</x-app-layout>
