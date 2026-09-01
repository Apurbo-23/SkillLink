<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 style="color: #D4AF37; font-weight: 700; font-size: 1.875rem;">Admin Dashboard</h2>
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
        .stat-card {
            background-color: #1a1814 !important;
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 0.5rem;
            padding: 1.5rem;
            color: #e8dfc8;
        }
        .stat-number {
            font-size: 2.25rem;
            font-weight: 700;
            color: #D4AF37;
        }
        .stat-label {
            color: #9a8a6a;
            font-size: 0.875rem;
            margin-top: 0.5rem;
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
        .nav-link:hover {
            background-color: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
            border-color: rgba(212, 175, 55, 0.4);
        }
        .section-title {
            color: #D4AF37;
            font-weight: 700;
            font-size: 1.125rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
            padding-bottom: 0.75rem;
        }
        .dispute-item {
            background-color: #1a1814;
            border-left: 4px solid #f5b7b1;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-radius: 0.375rem;
        }
        .dispute-reason {
            color: #e8dfc8;
            font-size: 0.95rem;
            margin: 0.5rem 0;
        }
        .dispute-user {
            color: #D4AF37;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #D4AF37;
            color: #0B0A09;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #e8c13f;
        }
        .btn-secondary {
            background-color: #1a1814;
            color: #9a8a6a;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(212, 175, 55, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
        }
    </style>

    <div class="py-8" style="background-color: #0B0A09; min-height: 100vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="nav-link" style="background-color: rgba(212, 175, 55, 0.15); color: #D4AF37; border-color: #D4AF37;">Dashboard</a>
                <a href="{{ route('admin.disputes') }}" class="nav-link">Disputes</a>
                <a href="{{ route('admin.listings') }}" class="nav-link">Listings</a>
                <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['open_disputes'] }}</div>
                    <div class="stat-label">Open Disputes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['pending_listings'] }}</div>
                    <div class="stat-label">Pending Listings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['suspended_users'] }}</div>
                    <div class="stat-label">Suspended Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>

            <!-- Recent Disputes -->
            <div class="stat-card">
                <div class="section-title">Recent Disputes (Open)</div>

                @forelse ($recentDisputes as $dispute)
                    <div class="dispute-item">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div class="dispute-user">{{ $dispute->raisedBy->name }}</div>
                                <div class="dispute-reason">
                                    <strong>Reason:</strong> {{ $dispute->reason }}
                                </div>
                                <div style="color: #9a8a6a; font-size: 0.8rem; margin-top: 0.5rem;">
                                    <strong>Swap:</strong> {{ $dispute->swapRequest->id }} • 
                                    <strong>Raised:</strong> {{ $dispute->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <a href="{{ route('admin.disputes') }}" class="btn-primary">Review</a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: #9a8a6a;">
                        No open disputes at the moment.
                    </div>
                @endforelse
            </div>

            <!-- Quick Actions -->
            <div class="stat-card" style="margin-top: 2rem;">
                <div class="section-title">Quick Actions</div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <a href="{{ route('admin.disputes') }}" class="btn-primary" style="display: flex; align-items: center; justify-content: center; padding: 1rem;">
                         Review Disputes
                    </a>
                    <a href="{{ route('admin.listings') }}" class="btn-primary" style="display: flex; align-items: center; justify-content: center; padding: 1rem;">
                         Manage Listings
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn-primary" style="display: flex; align-items: center; justify-content: center; padding: 1rem;">
                         Manage Users
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
