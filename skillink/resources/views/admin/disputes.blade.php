<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 style="color: #D4AF37; font-weight: 700; font-size: 1.875rem;">Dispute Management</h2>
            <div style="color: #9a8a6a; font-size: 0.875rem;">{{ auth()->user()->name }} (Admin)</div>
        </div>
    </x-slot>

    <style>
        body, .bg-gray-100 {
            background-color: #0B0A09 !important;
        }
        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .nav-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            color: #9a8a6a;
            text-decoration: none;
            font-size: 0.875rem;
            margin-right: 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }
        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(212, 175, 55, 0.15);
            color: #D4AF37;
            border-color: rgba(212, 175, 55, 0.4);
        }
        .dispute-card {
            background-color: #1a1814;
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: #e8dfc8;
        }
        .dispute-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            padding-bottom: 0.75rem;
        }
        .dispute-user {
            color: #D4AF37;
            font-weight: 600;
            font-size: 1.05rem;
        }
        .dispute-status {
            color: #f5b7b1;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .dispute-reason {
            background-color: #121110;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin: 0.75rem 0;
            border-left: 3px solid #f5b7b1;
            color: #e8dfc8;
        }
        .dispute-section {
            margin: 1rem 0;
        }
        .dispute-label {
            color: #9a8a6a;
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
        }
        .dispute-value {
            color: #e8dfc8;
            margin-top: 0.25rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            color: #9a8a6a;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        textarea {
            width: 100%;
            background-color: #121110;
            color: #e8dfc8;
            border: 1px solid rgba(212, 175, 55, 0.25);
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-family: inherit;
        }
        textarea:focus {
            outline: none;
            border-color: #D4AF37;
            background-color: rgba(212, 175, 55, 0.05);
        }
        .btn-resolve {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-resolve:hover {
            background-color: #45a049;
        }
        .btn-dismiss {
            background-color: #f44336;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-dismiss:hover {
            background-color: #da190b;
        }
        .swap-details {
            background-color: #121110;
            padding: 1rem;
            border-radius: 0.375rem;
            margin: 0.75rem 0;
            font-size: 0.9rem;
        }
        .swap-details-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }
        .swap-details-item:last-child {
            border-bottom: none;
        }
        .success-message {
            background-color: rgba(76, 175, 80, 0.2);
            border: 1px solid #4CAF50;
            color: #4CAF50;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="py-8" style="background-color: #0B0A09; min-height: 100vh;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('admin.disputes') }}" class="nav-link active">Disputes</a>
                <a href="{{ route('admin.listings') }}" class="nav-link">Listings</a>
                <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
            </div>

            @if(session('success'))
                <div class="success-message">✓ {{ session('success') }}</div>
            @endif

            @forelse ($disputes as $dispute)
                <div class="dispute-card">
                    <!-- Dispute Header -->
                    <div class="dispute-header">
                        <div>
                            <div class="dispute-user">{{ $dispute->raisedBy->name }}</div>
                            <div class="dispute-status">Raised: {{ $dispute->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div class="dispute-status" style="color: #f5b7b1;">● OPEN</div>
                        </div>
                    </div>

                    <!-- Dispute Details -->
                    <div class="dispute-section">
                        <div class="dispute-label">Reason for Dispute</div>
                        <div class="dispute-reason">
                            {{ $dispute->reason }}
                        </div>
                    </div>

                    <!-- Swap Details -->
                    <div class="dispute-section">
                        <div class="dispute-label">Related Swap Details</div>
                        <div class="swap-details">
                            <div class="swap-details-item">
                                <span style="color: #9a8a6a;">Swap ID:</span>
                                <span style="color: #D4AF37; font-weight: 600;">#{{ $dispute->swapRequest->id }}</span>
                            </div>
                            <div class="swap-details-item">
                                <span style="color: #9a8a6a;">Requester:</span>
                                <span style="color: #e8dfc8;">{{ $dispute->swapRequest->requester->name }}</span>
                            </div>
                            <div class="swap-details-item">
                                <span style="color: #9a8a6a;">Provider:</span>
                                <span style="color: #e8dfc8;">{{ $dispute->swapRequest->provider->name }}</span>
                            </div>
                            <div class="swap-details-item">
                                <span style="color: #9a8a6a;">Status:</span>
                                <span style="color: #D4AF37; font-weight: 600;">{{ ucfirst($dispute->swapRequest->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Resolution Form -->
                    <form method="POST" action="{{ route('admin.disputes.resolve', $dispute) }}" class="dispute-section">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" rows="4" placeholder="Add detailed notes about your resolution..."></textarea>
                        </div>

                        <div style="display: flex; gap: 0.75rem;">
                            <button type="submit" name="status" value="resolved" class="btn-resolve">
                                ✓ Resolve Dispute
                            </button>
                            <button type="submit" name="status" value="dismissed" class="btn-dismiss">
                                ✕ Dismiss Dispute
                            </button>
                        </div>
                    </form>

                    @if($dispute->admin_notes)
                        <div class="dispute-section" style="background-color: rgba(212, 175, 55, 0.05); padding: 0.75rem; border-radius: 0.375rem; border-left: 3px solid #D4AF37;">
                            <div class="dispute-label">Previous Admin Notes</div>
                            <div class="dispute-value" style="margin-top: 0.5rem;">{{ $dispute->admin_notes }}</div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="dispute-card" style="text-align: center; padding: 3rem;">
                    <div style="color: #9a8a6a; font-size: 1rem; margin-bottom: 0.5rem;">✓ All disputes resolved!</div>
                    <div style="color: #9a8a6a; font-size: 0.875rem;">No open disputes at the moment.</div>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>