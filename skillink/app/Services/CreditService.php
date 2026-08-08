<?php

namespace App\Services;

use App\Models\CreditTransaction;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreditService
{
    /**
     * Deduct credits from a user (e.g. sending a swap request) and log it.
     * Returns false without changing anything if the user can't afford it.
     */
    public function spend(User $user, int $amount, string $description, ?SwapRequest $swapRequest = null): bool
    {
        if ($amount <= 0) {
            return true;
        }

        if ($user->credits < $amount) {
            return false;
        }

        DB::transaction(function () use ($user, $amount, $description, $swapRequest) {
            $user->decrement('credits', $amount);

            CreditTransaction::create([
                'user_id' => $user->id,
                'swap_request_id' => $swapRequest?->id,
                'type' => 'spent',
                'amount' => -$amount,
                'description' => $description,
            ]);
        });

        return true;
    }

    /**
     * Add credits to a user (e.g. completing a swap) and log it.
     */
    public function earn(User $user, int $amount, string $description, ?SwapRequest $swapRequest = null): void
    {
        if ($amount <= 0) {
            return;
        }

        DB::transaction(function () use ($user, $amount, $description, $swapRequest) {
            $user->increment('credits', $amount);

            CreditTransaction::create([
                'user_id' => $user->id,
                'swap_request_id' => $swapRequest?->id,
                'type' => 'earned',
                'amount' => $amount,
                'description' => $description,
            ]);
        });
    }

    /**
     * Give credits back to a user (e.g. a request was rejected/cancelled).
     */
    public function refund(User $user, int $amount, string $description, ?SwapRequest $swapRequest = null): void
    {
        if ($amount <= 0) {
            return;
        }

        DB::transaction(function () use ($user, $amount, $description, $swapRequest) {
            $user->increment('credits', $amount);

            CreditTransaction::create([
                'user_id' => $user->id,
                'swap_request_id' => $swapRequest?->id,
                'type' => 'refunded',
                'amount' => $amount,
                'description' => $description,
            ]);
        });
    }
}
