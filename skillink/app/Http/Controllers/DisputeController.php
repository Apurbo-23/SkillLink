<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\SwapRequest;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function store(Request $request, SwapRequest $swapRequest)
    {
        abort_unless(
            in_array($request->user()->id, [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );

        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        Dispute::create([
            'swap_request_id' => $swapRequest->id,
            'raised_by_id' => $request->user()->id,
            'reason' => $validated['reason'],
            'status' => 'open',
        ]);

        return back()->with('success', 'Dispute submitted. An admin will review it.');
    }
}