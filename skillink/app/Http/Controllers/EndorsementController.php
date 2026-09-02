<?php

namespace App\Http\Controllers;

use App\Models\Endorsement;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Notifications\EndorsementReceived;

class EndorsementController extends Controller
{
    public function store(Request $request, User $user)
    {
        abort_if($request->user()->id === $user->id, 403);

        $validated = $request->validate([
            'skill' => 'required|string|max:255',
        ]);

        $skill = $validated['skill'];

        // The selected skill must actually belong to the user's active listing.
        abort_unless(
            $user->skillOfferings()
                ->where('skill_name', $skill)
                ->exists(),
            422,
            'This user does not offer that skill.'
        );

        // Both users must have completed a swap together.
        $completedSwap = SwapRequest::where('status', 'completed')
            ->where(function ($query) use ($request, $user) {
                $query->where(function ($q) use ($request, $user) {
                    $q->where('requester_id', $request->user()->id)
                        ->where('provider_id', $user->id);
                })->orWhere(function ($q) use ($request, $user) {
                    $q->where('requester_id', $user->id)
                        ->where('provider_id', $request->user()->id);
                });
            })
            ->exists();

        abort_unless(
            $completedSwap,
            403,
            'You can only endorse someone after completing a swap together.'
        );

        // Prevent duplicate endorsements for the same skill.
        $alreadyEndorsed = Endorsement::where('endorser_id', $request->user()->id)
            ->where('endorsed_user_id', $user->id)
            ->where('skill', $skill)
            ->exists();

        if ($alreadyEndorsed) {
            return back()->with('error', 'You have already endorsed this skill.');
        }

        Endorsement::create([
            'endorser_id' => $request->user()->id,
            'endorsed_user_id' => $user->id,
            'skill' => $skill,
        ]);

        // $endorsedUser = $endorsement->endorsedUser; // adjust to your actual relationship name
        // $endorsedUser->notify(new EndorsementReceived($endorsement));

        return back()->with('success', "You endorsed {$user->name} for {$skill}.");
    }
}
