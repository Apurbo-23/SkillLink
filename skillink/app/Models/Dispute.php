<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = ['swap_request_id', 'raised_by_id', 'reason', 'status', 'admin_notes', 'resolved_by_id'];

    public function swapRequest()
    {
        return $this->belongsTo(SwapRequest::class);
    }

    public function raisedBy()
    {
        return $this->belongsTo(User::class, 'raised_by_id');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by_id');
    }
}
