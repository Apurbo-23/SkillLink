<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Swap Requests</h2>
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

        .status-badge {
            padding: 0.15rem 0.6rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            border: 1px solid rgba(212,175,55,0.25);
            background-color: #0B0A09;
            color: #D4AF37;
        }

        .tab-btn {
            background-color: #1f1e1c;
            border: 1px solid #cdac40;
            color: #c9bd9a;
        }
    </style>

    <div class="py-8 max-w-5xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;" x-data="{ activeTab: 'received' }">
        @if (session('success'))
            <div class="mb-4 p-4 rounded" style="background-color: #1a1814; color: #D4AF37; border: 1px solid rgba(212,175,55,0.25);">{{ session('success') }}</div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <p style="color: #e8dfc8;">
                Your balance: <span style="color:#D4AF37; font-weight:700;">{{ auth()->user()->credits }} credits</span>
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-6">
            <button type="button" class="tab-btn" :class="activeTab === 'received' ? 'active' : ''" @click="activeTab = 'received'"
                style="background-color:#1a1814; border:1.5px solid rgb(187, 154, 47); color:#c9bd9a; border-radius:0.75rem; padding:0.75rem 1rem; font-weight:500;"
                :style="activeTab === 'received' ? 'background-color:rgb(15, 14, 13); border-color:#D4AF37; color:#D4AF37' : ''">
                Received ({{ $received->count() }})
            </button>
            <button type="button" class="tab-btn" :class="activeTab === 'sent' ? 'active' : ''" @click="activeTab = 'sent'"
                style="background-color:#1a1814; border:1.5px solid rgb(197, 162, 46); color:#c9bd9a; border-radius:0.75rem; padding:0.75rem 1rem; font-weight:500;"
                :style="activeTab === 'sent' ? 'background-color:rgb(15, 14, 13); border-color:#D4AF37; color:#D4AF37;' : ''">
                Sent ({{ $sent->count() }})
            </button>
        </div>

        <div x-show="activeTab === 'received'" x-transition class="overflow-hidden rounded-lg border" style="border-color: #D4AF37; background-color: #121110;">
            <table class="w-full" style="border-collapse: collapse; color: #e8dfc8;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(212,175,55,0.25); background-color: #0B0A09;">
                        <th class="p-3 text-left" style="color: #D4AF37;">From</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Listing</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Credits</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Status</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($received as $swapRequest)
                        <tr style="border-bottom: 1px solid rgba(212,175,55,0.16);">
                            <td class="p-3">{{ $swapRequest->requester->name }}</td>
                            <td class="p-3">
                                <a href="{{ route('swap-requests.show', $swapRequest) }}" style="color:#D4AF37;">
                                    {{ $swapRequest->listing->skill_offered }}
                                </a>
                            </td>
                            <td class="p-3">{{ $swapRequest->credits_amount }}</td>
                            <td class="p-3"><span class="status-badge">{{ $swapRequest->stageLabel() }}</span></td>
                            <td class="p-3 space-x-2">
                                @if ($swapRequest->status === 'pending')
                                    <form method="POST" action="{{ route('swap-requests.accept', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('swap-requests.reject', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#f5b7b1; font-weight:600;" class="text-sm">Decline</button>
                                    </form>
                                @elseif ($swapRequest->status === 'accepted')
                                    <form method="POST" action="{{ route('swap-requests.start', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Start Swap</button>
                                    </form>
                                @elseif ($swapRequest->status === 'in_progress')
                                    <form method="POST" action="{{ route('swap-requests.complete', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Mark Completed</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-4 text-center" style="color: #9a8a6a;">No swap requests received yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="activeTab === 'sent'" x-transition class="overflow-hidden rounded-lg border" style="border-color: #D4AF37; background-color: #121110;">
            <table class="w-full" style="border-collapse: collapse; color: #e8dfc8;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(212,175,55,0.25); background-color: #0B0A09;">
                        <th class="p-3 text-left" style="color: #D4AF37;">To</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Listing</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Credits</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Status</th>
                        <th class="p-3 text-left" style="color: #D4AF37;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sent as $swapRequest)
                        <tr style="border-bottom: 1px solid rgba(212,175,55,0.16);">
                            <td class="p-3">{{ $swapRequest->provider->name }}</td>
                            <td class="p-3">
                                <a href="{{ route('swap-requests.show', $swapRequest) }}" style="color:#D4AF37;">
                                    {{ $swapRequest->listing->skill_offered }}
                                </a>
                            </td>
                            <td class="p-3">{{ $swapRequest->credits_amount }}</td>
                            <td class="p-3"><span class="status-badge">{{ $swapRequest->stageLabel() }}</span></td>
                            <td class="p-3 space-x-2">
                                @if ($swapRequest->status === 'pending')
                                    <form method="POST" action="{{ route('swap-requests.cancel', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#f5b7b1; font-weight:600;" class="text-sm">Cancel</button>
                                    </form>
                                @elseif ($swapRequest->status === 'accepted')
                                    <form method="POST" action="{{ route('swap-requests.start', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Start Swap</button>
                                    </form>
                                @elseif ($swapRequest->status === 'in_progress')
                                    <form method="POST" action="{{ route('swap-requests.complete', $swapRequest) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button style="color:#D4AF37; font-weight:600;" class="text-sm">Mark Completed</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-4 text-center" style="color: #9a8a6a;">You haven't sent any swap requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
