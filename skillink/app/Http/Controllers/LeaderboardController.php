<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::all()->map(function ($user) {
            $completedSwaps =
                $user->swapRequestsSent()->where('status', 'completed')->count()
                + $user->swapRequestsReceived()->where('status', 'completed')->count();

            $user->completed_swaps = $completedSwaps;
            $user->average_rating = $user->averageRating();

            return $user;
        })
        ->sort(function ($a, $b) {
            // First: completed swaps, highest first
            if ($a->completed_swaps !== $b->completed_swaps) {
                return $b->completed_swaps <=> $a->completed_swaps;
            }

            // Second: average rating, highest first
            return ($b->average_rating ?? 0) <=> ($a->average_rating ?? 0);
        })
        ->values();

        return view('leaderboard.index', compact('users'));
    }
}
