<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #222; font-size: 12px; }
        h1 { color: #B8860B; font-size: 20px; margin-bottom: 0; }
        h2 { color: #B8860B; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 4px; margin-top: 24px; }
        .badge { display: inline-block; background: #f5e9c8; border: 1px solid #B8860B; color: #7a5c00; padding: 2px 8px; border-radius: 3px; margin-right: 4px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        td, th { padding: 4px 6px; border-bottom: 1px solid #eee; text-align: left; font-size: 11px; }
    </style>
</head>
<body>
    <h1>{{ $user->name }}</h1>
    <p>{{ $user->email }}</p>
    <p>Average rating: {{ $averageRating ? number_format($averageRating, 1) . ' / 5' : 'No ratings yet' }} ({{ $ratingCount }} reviews)</p>
    <p>Completed swaps: {{ $completedSwaps }}</p>

    <h2>Badges</h2>
    @forelse ($badges as $badge)
        <span class="badge">{{ $badge }}</span>
    @empty
        <p>No badges earned yet.</p>
    @endforelse

    <h2>Active Listings</h2>
    @forelse ($skillOfferings as $skill)
        <p><strong>{{ $skill->skill_name }}</strong> ↔ ({{ $skill->category }})</p>
    @empty
        <p>No active listings.</p>
    @endforelse

    <h2>Portfolio</h2>
    @forelse ($portfolioItems as $item)
        <p><strong>{{ $item->title ?? 'Untitled' }}</strong> — {{ $item->description ?? '' }}</p>
    @empty
        <p>No portfolio items added.</p>
    @endforelse

    <h2>Recent Ratings</h2>
    @forelse ($ratings as $rating)
        <table>
            <tr>
                <td>{{ $rating->rater->name }}</td>
                <td>{{ $rating->score }} / 5</td>
                <td>{{ $rating->review }}</td>
            </tr>
        </table>
    @empty
        <p>No ratings received yet.</p>
    @endforelse

    <h2>Endorsements</h2>
    @forelse ($endorsements as $skill => $count)
        <p>{{ $skill }} — endorsed {{ $count }} time(s)</p>
    @empty
        <p>No endorsements yet.</p>
    @endforelse
</body>
</html>
