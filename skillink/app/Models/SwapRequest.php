<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SwapRequest extends Model
{
    protected $fillable = [
        'listing_id', 'requester_id', 'provider_id', 'message', 'credits_amount', 'status',
    ];

    /**
     * The main happy-path stages a swap moves through, in order, mapped to
     * a display label. 'rejected' and 'cancelled' are side-exits from this
     * flow rather than stops along it, so they're handled separately in
     * the views instead of being listed here.
     */
    public const STAGES = [
        'pending' => 'Proposed',
        'accepted' => 'Accepted',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function creditTransactions(): HasMany
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * True if this swap left the main flow via rejection or cancellation,
     * rather than progressing through it.
     */
    public function isSidelined(): bool
    {
        return in_array($this->status, ['rejected', 'cancelled'], true);
    }

    /**
     * Human-readable label for the current status, for display to either party.
     */
    public function stageLabel(): string
    {
        return self::STAGES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * 0-based position of the current status within STAGES, or null if
     * the swap isn't on the main flow (rejected/cancelled).
     */
    public function stageIndex(): ?int
    {
        $position = array_search($this->status, array_keys(self::STAGES), true);

        return $position === false ? null : $position;
    }
}
