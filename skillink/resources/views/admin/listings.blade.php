<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 style="color: #D4AF37; font-weight: 700; font-size: 1.875rem;">Listings Management</h2>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #1a1814;
            color: #D4AF37;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
            font-size: 0.875rem;
            text-transform: uppercase;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            color: #e8dfc8;
        }
        tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.05);
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-active {
            background-color: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .status-open {
            background-color: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            border: 1px solid #D4AF37;
        }
        .status-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #FFC107;
            border: 1px solid #FFC107;
        }
        .status-removed {
            background-color: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid #f44336;
        }
        .btn-small {
            padding: 0.4rem 0.8rem;
            border-radius: 0.3rem;
            font-size: 0.75rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-approve {
            background-color: #4CAF50;
            color: white;
        }
        .btn-approve:hover {
            background-color: #45a049;
        }
        .btn-remove {
            background-color: #f44336;
            color: white;
        }
        .btn-remove:hover {
            background-color: #da190b;
        }
        .table-container {
            background-color: #121110;
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .success-message {
            background-color: rgba(76, 175, 80, 0.2);
            border: 1px solid #4CAF50;
            color: #4CAF50;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #9a8a6a;
        }
    </style>

    <div class="py-8" style="background-color: #0B0A09; min-height: 100vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('admin.disputes') }}" class="nav-link">Disputes</a>
                <a href="{{ route('admin.listings') }}" class="nav-link active">Listings</a>
                <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
            </div>

            @if(session('success'))
                <div class="success-message">✓ {{ session('success') }}</div>
            @endif

            @if($listings->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Skill Offered</th>
                                <th>Skill Wanted</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listings as $listing)
                                <tr>
                                    <td>
                                        <a href="{{ route('profile.public', $listing->user->profile_slug) }}" style="color: #D4AF37; text-decoration: none; font-weight: 600;">
                                            {{ $listing->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $listing->skill_offered }}</td>
                                    <td>{{ $listing->skill_wanted }}</td>
                                    <td>{{ $listing->category }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $listing->status }}">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    </td>
                                    <td style="font-size: 0.875rem; color: #9a8a6a;">
                                        {{ $listing->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if($listing->status !== 'active')
                                            <form method="POST" action="{{ route('admin.listings.approve', $listing) }}" style="display: inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-small btn-approve">Approve</button>
                                            </form>
                                        @endif

                                        @if($listing->status !== 'removed')
                                            <form method="POST" action="{{ route('admin.listings.remove', $listing) }}" style="display: inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-small btn-remove">Remove</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-container empty-state">
                    <div style="font-size: 1rem; color: #D4AF37; margin-bottom: 0.5rem;">✓ All listings approved!</div>
                    <div>No pending listings to review.</div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
