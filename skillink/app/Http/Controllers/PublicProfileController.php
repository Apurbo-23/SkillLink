<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicProfileController extends Controller
{
    /**
     * Public, no-login-required profile page. Shows a user's active
     * listings, portfolio, average rating, and endorsement counts.
     */
    public function show(string $slug)
    {
        $user = User::where('profile_slug', $slug)->firstOrFail();

        $data = $this->gatherProfileData($user);

        return view('profile.public', $data);
    }

    public function downloadPdf(Request $request)
    {
        $user = $request->user();

        $data = $this->gatherProfileData($user);

        $pdf = Pdf::loadView('profile.pdf', $data);

        return $pdf->download("{$user->name}-skilllink-profile.pdf");
    }

    protected function gatherProfileData(User $user): array
    {
        // $user = User::where('profile_slug', $slug)->firstOrFail();

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
        return compact(
            'user', 'listings', 'portfolioItems', 'ratings',
            'endorsements', 'averageRating', 'ratingCount', 'completedSwaps', 'badges'
        );
    }
}
