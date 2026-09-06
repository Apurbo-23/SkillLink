<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
.logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: rgba(245, 244, 238, 0.97);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .logo-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: rgba(234, 193, 29, 0.97);
            display: inline-block;
            flex-shrink: 0;
        }
</style>

<!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <div class="logo">
                            <span class="logo-dot"></span>
                            <span>SkillLink</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (hidden for admin users) -->
                @if(!auth()->user()->is_admin)
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('swap-requests.index')" :active="request()->routeIs('swap-requests.*')">
                        {{ __('Swap Request') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                        {{ __('Sessions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.*')">
                        {{ __('Listings') }}
                    </x-nav-link>
                    <x-nav-link
                        :href="route('skillselection')"
                        :active="request()->routeIs('skillselection')"
                        onclick="localStorage.setItem('skilllink_active_tab', 'searching');"
                    >
                        {{ __('Skill Selection') }}
                    </x-nav-link>
                    <x-nav-link :href="route('leaderboard.index')"
                        :active="request()->routeIs('leaderboard.*')"
                    >
                        {{ __('Leaderboard') }}
                    </x-nav-link>
                    <x-nav-link
                        :href="route('analytics.index')"
                        :active="request()->routeIs('analytics.*')"
                    >
                        {{ __('Analytics') }}
                    </x-nav-link>
                    <x-nav-link :href="route('availability.index')" :active="request()->routeIs('availability.*')">
                        {{ __('Availability') }}
                    </x-nav-link>

                </div>
                @endif
            </div>


            <!--search icon and setting Dropdown -->
            @if(!auth()->user()->is_admin)
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                    <a href="{{ route('search-skills') }}" class="inline-flex items-center justify-center p-2 rounded-md transition ease-in-out duration-150 me-2" title="Search Skills" style="color: #D4AF37;">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke: #D4AF37;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>

                    <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                    <x-dropdown-link :href="route('categories.index')"> {{ __('Skill Categories') }}

                         </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <!-- Admin Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div style="color: #957d30;">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.dashboard')" style="color: #a4882c;">
                            {{ __('Admin Dashboard') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" style="color: #a4882c;">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif

            <!--notification bell icon -->
            <div class="hidden sm:flex sm:items-center sm:ms-4" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" class="relative p-2 rounded-md" style="color: #D4AF37;"
                            @click="open = !open; if (open) fetch('{{ route('notifications.mark-read') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="absolute -top-1 -right-1 text-xs rounded-full px-1.5"
                                style="background-color:#D4AF37; color:#0B0A09;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-80 rounded shadow-lg z-50"
                        style="background-color:#121110; border:1px solid rgba(212,175,55,0.25);">
                        <div class="p-3 max-h-96 overflow-y-auto">
                            @forelse (auth()->user()->notifications->take(10) as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                    class="block p-2 mb-1 rounded text-sm"
                                    style="background-color: {{ $notification->read_at ? 'transparent' : 'rgba(212,175,55,0.08)' }}; color: #e8dfc8;">
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                    <div class="text-xs mt-1" style="color:#9a8a6a;">{{ $notification->created_at->diffForHumans() }}</div>
                                </a>
                            @empty
                                <p class="text-sm p-2" style="color:#9a8a6a;">No notifications yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.*')">
            {{ __('Listings') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
            {{ __('Sessions') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('swap-requests.index')" :active="request()->routeIs('swap-requests.*')">
            {{ __('Swap Requests') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link
            :href="route('skillselection')"
            :active="request()->routeIs('skillselection')"
            onclick="localStorage.setItem('skilllink_active_tab', 'searching');"
        >
            {{ __('Skill Selection') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('availability.index')" :active="request()->routeIs('availability.*')">
            {{ __('Availability') }}
        </x-responsive-nav-link>

    </div>
</nav>
