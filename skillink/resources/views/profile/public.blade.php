<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} · SkillLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .logo-dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        background: rgb(231, 205, 12);
        display: inline-block;
        flex-shrink: 0;
        }
        .logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }
    </style>
</head>
<body style="background-color:#0B0A09; color:#e8dfc8; min-height:100vh; font-family: Figtree, ui-sans-serif, system-ui;">

    <header style="border-bottom:1px solid rgba(212,175,55,0.15); background-color:#0f0e0c;">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="logo">
                <span class="logo-dot"></span>SkillLink
            </a>
            @auth
                <a href="{{ route('dashboard') }}" style="color:#9a8a6a; font-size:0.9rem;">Back to Dashboard</a>
            @endauth
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 py-10">

        {{-- ── Header card ── --}}
        <div class="p-6 rounded-lg border mb-6" style="background-color:#121110; border-color:#D4AF37;">
            <h1 class="text-2xl font-bold" style="color:#D4AF37;">{{ $user->name }}</h1>
            <p class="text-sm mt-1" style="color:#9a8a6a;">SkillLink member</p>

            <div class="flex flex-wrap gap-4 mt-4 text-sm">
                <div>
                    <span style="color:#D4AF37; font-weight:700;">
                        @if ($averageRating)
                            {{ $averageRating }} / 5
                        @else
                            No ratings yet
                        @endif
                    </span>
                    <span style="color:#9a8a6a;"> ({{ $ratingCount }} {{ Str::plural('rating', $ratingCount) }})</span>
                </div>
                <div>
                    <span style="color:#D4AF37; font-weight:700;">{{ $completedSwaps }}</span>
                    <span style="color:#9a8a6a;"> completed {{ Str::plural('swap', $completedSwaps) }}</span>
                </div>
            </div>
        </div>

        {{-- ── Badges ── --}}
        <div class="p-6 rounded-lg border mb-6"
            style="background-color:#121110; border-color:rgba(212,175,55,0.3);">

            <h2 class="font-semibold mb-3" style="color:#D4AF37;">Badges</h2>

            @forelse ($badges as $badge)
                <span class="inline-block mr-2 mb-2 px-3 py-1 rounded-full text-sm"
                    style="background-color:#0f0e0c; border:1px solid rgba(212,175,55,0.25); color:#e8dfc8;">
                    {{ $badge }}
                </span>
            @empty
                <p class="text-sm" style="color:#9a8a6a;">
                    No badges earned yet.
                </p>
            @endforelse

        </div>

        {{-- ── Skills ── --}}
        <div class="p-6 rounded-lg border mb-6"
            style="background-color:#121110; border-color:rgba(212,175,55,0.3);">

            <h2 class="font-semibold mb-3" style="color:#D4AF37;">Skills</h2>

            @forelse ($listings as $listing)

                <div class="mb-3 p-3 rounded"
                    style="background-color:#0f0e0c; border:1px solid rgba(212,175,55,0.12);">

                    <div>
                        <span style="color:#D4AF37; font-weight:600;">
                            {{ $listing->skill_offered }}
                        </span>

                        <span style="color:#9a8a6a;"> for </span>

                        <span style="color:#e8dfc8;">
                            {{ $listing->skill_wanted }}
                        </span>

                        @if ($listing->category)
                            <span class="ml-2 text-xs" style="color:#9a8a6a;">
                                &middot; {{ $listing->category }}
                            </span>
                        @endif
                    </div>

                    @auth
                        @if (Auth::id() !== $user->id)

                            <form method="POST"
                                action="{{ route('endorsements.store', $user) }}"
                                class="mt-3">

                                @csrf

                                <input type="hidden"
                                    name="skill"
                                    value="{{ $listing->skill_offered }}">

                                <button type="submit"
                                        class="px-3 py-2 rounded text-sm"
                                        style="background-color:#D4AF37; color:#0B0A09; font-weight:600;">
                                    Endorse {{ $listing->skill_offered }}
                                </button>

                            </form>

                        @endif
                    @endauth

                </div>

            @empty

                <p class="text-sm" style="color:#9a8a6a;">
                    No active skill listings right now.
                </p>

            @endforelse
        </div>

        {{-- ── Portfolio ── --}}
        <div class="p-6 rounded-lg border mb-6" style="background-color:#121110; border-color:rgba(212,175,55,0.3);">
            <h2 class="font-semibold mb-3" style="color:#D4AF37;">Portfolio</h2>
            @forelse ($portfolioItems as $item)
                <div class="mb-3 p-3 rounded" style="background-color:#0f0e0c; border:1px solid rgba(212,175,55,0.12);">
                    <div style="color:#e8dfc8; font-weight:600;">{{ $item->title }}</div>
                    @if ($item->description)
                        <p class="text-sm mt-1" style="color:#9a8a6a;">{{ $item->description }}</p>
                    @endif
                    @if ($item->link_url)
                        <a href="{{ $item->link_url }}" target="_blank" rel="noopener" class="text-sm" style="color:#D4AF37;">View link &rarr;</a>
                    @endif
                </div>
            @empty
                <p class="text-sm" style="color:#9a8a6a;">No portfolio items added yet.</p>
            @endforelse
        </div>

        {{-- ── Endorsements ── --}}
        <div class="p-6 rounded-lg border mb-6" style="background-color:#121110; border-color:rgba(212,175,55,0.3);">
            <h2 class="font-semibold mb-3" style="color:#D4AF37;">Endorsements</h2>
            @forelse ($endorsements as $skill => $count)
                <span class="inline-block mr-2 mb-2 px-3 py-1 rounded-full text-sm"
                      style="background-color:#0f0e0c; border:1px solid rgba(212,175,55,0.25); color:#e8dfc8;">
                    {{ $skill }} <span style="color:#D4AF37;">&times;{{ $count }}</span>
                </span>
            @empty
                <p class="text-sm" style="color:#9a8a6a;">No endorsements yet.</p>
            @endforelse
        </div>

        {{-- ── Ratings / reviews ── --}}
        <div class="p-6 rounded-lg border" style="background-color:#121110; border-color:rgba(212,175,55,0.3);">
            <h2 class="font-semibold mb-3" style="color:#D4AF37;">Recent Reviews</h2>
            @forelse ($ratings as $rating)
                <div class="mb-3 p-3 rounded" style="background-color:#0f0e0c; border:1px solid rgba(212,175,55,0.12);">
                    <div style="color:#D4AF37; font-weight:600;">
                        {{ str_repeat('★', $rating->score) }}{{ str_repeat('☆', 5 - $rating->score) }}
                    </div>
                    @if ($rating->review)
                        <p class="text-sm mt-1" style="color:#e8dfc8;">{{ $rating->review }}</p>
                    @endif
                    <p class="text-xs mt-1" style="color:#9a8a6a;">&mdash; {{ $rating->rater->name }}</p>
                </div>
            @empty
                <p class="text-sm" style="color:#9a8a6a;">No reviews yet.</p>
            @endforelse
        </div>

    </div>
</body>
</html>
