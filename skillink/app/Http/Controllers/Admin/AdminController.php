<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'open_disputes' => Dispute::where('status', 'open')->count(),
            'pending_listings' => Listing::where('status', 'open')->count(),
            'suspended_users' => User::where('is_suspended', true)->count(),
            'total_users' => User::where('is_admin', false)->count(),
        ];

        $recentDisputes = Dispute::with(['swapRequest', 'raisedBy'])
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentDisputes'));
    }

    // ── Disputes ──
    public function disputes()
    {
        $disputes = Dispute::with(['swapRequest', 'raisedBy'])
            ->where('status', 'open')
            ->latest()
            ->get();

        return view('admin.disputes', compact('disputes'));
    }

    public function resolveDispute(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'status' => 'required|in:resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $dispute->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'resolved_by_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Dispute updated.');
    }

    // ── Listings ──
    public function listings()
    {
        $listings = Listing::with('user')->latest()->get();

        return view('admin.listings', compact('listings'));
    }

    public function approveListing(Listing $listing)
    {
        $listing->update(['status' => 'active']);
        return back()->with('success', 'Listing approved.');
    }

    public function removeListing(Listing $listing)
    {
        $listing->update(['status' => 'removed']);
        return back()->with('success', 'Listing removed.');
    }

    // ── Users ──
    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function suspendUser(User $user)
    {
        abort_if($user->is_admin, 403, 'Cannot suspend an admin.');
        $user->update(['is_suspended' => true]);
        return back()->with('success', 'User suspended.');
    }

    public function unsuspendUser(User $user)
    {
        $user->update(['is_suspended' => false]);
        return back()->with('success', 'User unsuspended.');
    }
}