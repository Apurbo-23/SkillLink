<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    /**
     * Public, no-login-required profile page. Shows a user's active
     * listings, portfolio, average rating, and endorsement counts.
     */
    public function show(string $slug)
    {
        $user = User::where('profile_slug', $slug)->firstOrFail();

        $listings = $user->listings()->where('status', 'active')->get();
        $portfolioItems = $user->portfolioItems()->latest()->get();
        $ratings = $user->ratingsReceived()->with('rater')->latest()->take(10)->get();
        $endorsements = $user->endorsementCountsBySkill();
        $averageRating = $user->averageRating();
        $ratingCount = $user->ratingsReceived()->count();

        $completedSwaps = $user->swapRequestsSent()->where('status', 'completed')->count()
            + $user->swapRequestsReceived()->where('status', 'completed')->count();

        $badges = [];
        if ($completedSwaps >= 1){
            $badges[] = 'First Swap';
        }
        if ($completedSwaps >= 10){
            $badges[] = '10 Swaps completed';
        }
        if ($user->averageRating()!== null && $user->averageRating() >= 4.5){
            $badges[] = 'Top Rated';
        }
        return view('profile.public', compact(
            'user', 'listings', 'portfolioItems', 'ratings',
            'endorsements', 'averageRating', 'ratingCount', 'completedSwaps', 'badges'
        ));
    }
}
