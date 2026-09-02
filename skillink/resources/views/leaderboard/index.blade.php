<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">
            {{ __('Leaderboard') }}
        </h2>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-700">

                    <h1 class="text-2xl font-bold mb-2">
                        SkillLink Leaderboard
                    </h1>

                    <p class="text-gray-700 mb-6">
                        Top skill sharers ranked by completed swaps and average rating.
                    </p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                                        Rank
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                                        User
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                                        Completed Swaps
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                                        Average Rating
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($users as $index => $user)

                                    <tr>
                                        <td class="px-6 py-4">
                                            #{{ $index + 1 }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($user->profile_slug)
                                                <a
                                                    href="{{ route('profile.public', ['slug' => $user->profile_slug]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                >
                                                    {{ $user->name }}
                                                </a>
                                            @else
                                                {{ $user->name }}
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $user->completed_swaps }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($user->average_rating !== null)
                                                {{ number_format($user->average_rating, 1) }} / 5
                                            @else
                                                No ratings
                                            @endif
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
