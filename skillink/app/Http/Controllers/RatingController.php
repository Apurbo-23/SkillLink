<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\SwapRequest;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Show the rating form for a completed swap
     */
    public function create(SwapRequest $swapRequest)
    {
        // Only allow rating if swap is completed
        abort_unless($swapRequest->status === 'completed', 403);

        // Only allow the participants to rate
        abort_unless(
            in_array(auth()->id(), [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );

        // Check if user already rated this swap
        $existingRating = Rating::where('swap_request_id', $swapRequest->id)
            ->where('rater_id', auth()->id())
            ->exists();

        abort_if($existingRating, 403, 'You have already rated this swap.');

        // Determine who to rate (the other party)
        $ratedUserId = auth()->id() === $swapRequest->requester_id 
            ? $swapRequest->provider_id 
            : $swapRequest->requester_id;

        return view('ratings.create', compact('swapRequest', 'ratedUserId'));
    }

    /**
     * Store the rating and review
     */
    public function store(Request $request, SwapRequest $swapRequest)
    {
        // Only allow rating if swap is completed
        abort_unless($swapRequest->status === 'completed', 403);

        // Only allow the participants to rate
        abort_unless(
            in_array(auth()->id(), [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );

        // Check if user already rated this swap
        $existingRating = Rating::where('swap_request_id', $swapRequest->id)
            ->where('rater_id', auth()->id())
            ->exists();

        abort_if($existingRating, 403, 'You have already rated this swap.');

        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        // Determine who to rate (the other party)
        $ratedUserId = auth()->id() === $swapRequest->requester_id 
            ? $swapRequest->provider_id 
            : $swapRequest->requester_id;

        Rating::create([
            'rater_id' => auth()->id(),
            'rated_user_id' => $ratedUserId,
            'swap_request_id' => $swapRequest->id,
            'score' => $validated['score'],
            'review' => $validated['review'] ?? null,
        ]);

        return redirect()->route('swap-requests.show', $swapRequest)
            ->with('success', 'Rating submitted! Thank you for your feedback.');
    }
}
