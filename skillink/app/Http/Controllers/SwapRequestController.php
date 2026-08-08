<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\SwapRequest;
use App\Services\CreditService;
use Illuminate\Http\Request;

class SwapRequestController extends Controller
{
    public function __construct(protected CreditService $credits)
    {
    }

    /**
     * Requests the current user has sent and received.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $sent = SwapRequest::with(['listing', 'provider'])
            ->where('requester_id', $userId)
            ->latest()
            ->get();

        $received = SwapRequest::with(['listing', 'requester'])
            ->where('provider_id', $userId)
            ->latest()
            ->get();

        return view('swap-requests.index', compact('sent', 'received'));
    }

    /**
     * Form to send a swap request on someone else's listing.
     */
    public function create(Request $request, Listing $listing)
    {
        abort_if($listing->user_id === $request->user()->id, 403, 'You cannot request a swap on your own listing.');

        $cost = config('skilllink.swap_request_cost');

        return view('swap-requests.create', compact('listing', 'cost'));
    }

    /**
     * Send a formal swap request with a custom message. Spends credits
     * up front; they're refunded if the request is rejected/cancelled,
     * or paid to the provider once the swap is completed.
     */
    public function store(Request $request, Listing $listing)
    {
        abort_if($listing->user_id === $request->user()->id, 403, 'You cannot request a swap on your own listing.');

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $requester = $request->user();
        $cost = config('skilllink.swap_request_cost');

        if ($requester->credits < $cost) {
            return back()->withErrors([
                'message' => "You need at least {$cost} credits to send a swap request. Complete a swap to earn more.",
            ])->withInput();
        }

        $swapRequest = SwapRequest::create([
            'listing_id' => $listing->id,
            'requester_id' => $requester->id,
            'provider_id' => $listing->user_id,
            'message' => $validated['message'],
            'credits_amount' => $cost,
            'status' => 'pending',
        ]);

        $this->credits->spend(
            $requester,
            $cost,
            "Swap request sent for listing #{$listing->id}",
            $swapRequest
        );

        return redirect()->route('swap-requests.index')->with('success', 'Swap request sent!');
    }

    public function show(Request $request, SwapRequest $swapRequest)
    {
        abort_unless(
            in_array($request->user()->id, [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );

        $swapRequest->load(['listing', 'requester', 'provider', 'messages.sender']);

        return view('swap-requests.show', compact('swapRequest'));
    }

    /**
     * Provider accepts a pending request.
     */
    public function accept(Request $request, SwapRequest $swapRequest)
    {
        abort_unless($request->user()->id === $swapRequest->provider_id, 403);
        abort_unless($swapRequest->isPending(), 400, 'This request is no longer pending.');

        $swapRequest->update(['status' => 'accepted']);

        return back()->with('success', 'Swap request accepted.');
    }

    /**
     * Provider rejects a pending request; requester gets their credits back.
     */
    public function reject(Request $request, SwapRequest $swapRequest)
    {
        abort_unless($request->user()->id === $swapRequest->provider_id, 403);
        abort_unless($swapRequest->isPending(), 400, 'This request is no longer pending.');

        $swapRequest->update(['status' => 'rejected']);

        $this->credits->refund(
            $swapRequest->requester,
            $swapRequest->credits_amount,
            "Swap request #{$swapRequest->id} was rejected",
            $swapRequest
        );

        return back()->with('success', 'Swap request rejected.');
    }

    /**
     * Requester cancels their own pending request; they get their credits back.
     */
    public function cancel(Request $request, SwapRequest $swapRequest)
    {
        abort_unless($request->user()->id === $swapRequest->requester_id, 403);
        abort_unless($swapRequest->isPending(), 400, 'This request is no longer pending.');

        $swapRequest->update(['status' => 'cancelled']);

        $this->credits->refund(
            $swapRequest->requester,
            $swapRequest->credits_amount,
            "Swap request #{$swapRequest->id} was cancelled",
            $swapRequest
        );

        return back()->with('success', 'Swap request cancelled.');
    }

    /**
     * Either side marks an accepted swap as "in progress" once the work
     * has actually started, moving it into the next visible stage.
     */
    public function start(Request $request, SwapRequest $swapRequest)
    {
        abort_unless(
            in_array($request->user()->id, [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );
        abort_unless($swapRequest->isAccepted(), 400, 'Only accepted swaps can be started.');

        $swapRequest->update(['status' => 'in_progress']);

        return back()->with('success', 'Swap marked as in progress.');
    }

    /**
     * Either side marks an in-progress swap as completed; the provider
     * earns the held credits for delivering the skill.
     */
    public function complete(Request $request, SwapRequest $swapRequest)
    {
        abort_unless(
            in_array($request->user()->id, [$swapRequest->requester_id, $swapRequest->provider_id]),
            403
        );
        abort_unless($swapRequest->isInProgress(), 400, 'Only swaps in progress can be marked complete.');

        $swapRequest->update(['status' => 'completed']);

        $this->credits->earn(
            $swapRequest->provider,
            $swapRequest->credits_amount,
            "Completed swap request #{$swapRequest->id}",
            $swapRequest
        );

        return back()->with('success', 'Swap marked as completed. Credits released to the provider.');
    }
}
