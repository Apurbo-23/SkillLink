<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 style="color: #D4AF37; font-weight: 700; font-size: 1.875rem;">Users Management</h2>
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
        .user-name {
            color: #D4AF37;
            font-weight: 600;
            text-decoration: none;
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
        .status-suspended {
            background-color: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid #f44336;
        }
        .status-admin {
            background-color: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
            border: 1px solid #D4AF37;
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
        .btn-suspend {
            background-color: #f44336;
            color: white;
        }
        .btn-suspend:hover {
            background-color: #da190b;
        }
        .btn-unsuspend {
            background-color: #4CAF50;
            color: white;
        }
        .btn-unsuspend:hover {
            background-color: #45a049;
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
        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: #1a1814;
            color: #9a8a6a;
            border: 1px solid rgba(212, 175, 55, 0.2);
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .filter-btn:hover,
        .filter-btn.active {
            background-color: rgba(212, 175, 55, 0.15);
            color: #D4AF37;
            border-color: #D4AF37;
        }
    </style>

    <div class="py-8" style="background-color: #0B0A09; min-height: 100vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('admin.disputes') }}" class="nav-link">Disputes</a>
                <a href="{{ route('admin.listings') }}" class="nav-link">Listings</a>
                <a href="{{ route('admin.users') }}" class="nav-link active">Users</a>
            </div>

            @if(session('success'))
                <div class="success-message">✓ {{ session('success') }}</div>
            @endif

            <!-- Filter Buttons -->
            <div class="filters">
                <a href="{{ route('admin.users') }}" class="filter-btn active">All Users</a>
                <a href="{{ route('admin.users') }}?filter=suspended" class="filter-btn">Suspended Users</a>
                <a href="{{ route('admin.users') }}?filter=regular" class="filter-btn">Regular Users</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Credits</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('profile.public', $user->profile_slug) }}" class="user-name">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td style="font-size: 0.875rem; color: #9a8a6a;">{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="status-badge status-admin">Admin</span>
                                    @else
                                        <span style="color: #9a8a6a; font-size: 0.875rem;">User</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600; color: #D4AF37;">{{ $user->credits }}</td>
                                <td>
                                    <span class="status-badge {{ $user->is_suspended ? 'status-suspended' : 'status-active' }}">
                                        {{ $user->is_suspended ? 'Suspended' : 'Active' }}
                                    </span>
                                </td>
                                <td style="font-size: 0.875rem; color: #9a8a6a;">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    @if(!$user->is_admin)
                                        @if($user->is_suspended)
                                            <form method="POST" action="{{ route('admin.users.unsuspend', $user) }}" style="display: inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-small btn-unsuspend">Unsuspend</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.suspend', $user) }}" style="display: inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-small btn-suspend" onclick="return confirm('Are you sure?')">Suspend</button>
                                            </form>
                                        @endif
                                    @else
                                        <span style="color: #9a8a6a; font-size: 0.75rem;">Admin (Protected)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem; color: #9a8a6a;">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- User Stats Footer -->
            <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                <div style="background-color: #1a1814; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(212, 175, 55, 0.2); text-align: center;">
                    <div style="color: #D4AF37; font-weight: 700; font-size: 1.5rem;">{{ $users->count() }}</div>
                    <div style="color: #9a8a6a; font-size: 0.875rem;">Total Users</div>
                </div>
                <div style="background-color: #1a1814; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(212, 175, 55, 0.2); text-align: center;">
                    <div style="color: #4CAF50; font-weight: 700; font-size: 1.5rem;">{{ $users->where('is_suspended', false)->count() }}</div>
                    <div style="color: #9a8a6a; font-size: 0.875rem;">Active Users</div>
                </div>
                <div style="background-color: #1a1814; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(212, 175, 55, 0.2); text-align: center;">
                    <div style="color: #f44336; font-weight: 700; font-size: 1.5rem;">{{ $users->where('is_suspended', true)->count() }}</div>
                    <div style="color: #9a8a6a; font-size: 0.875rem;">Suspended Users</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
