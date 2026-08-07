<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $userID = $request->user()->id;

        $bookings = Booking::with(['requester', 'provider'])
            ->where('requester_id', $userID)
            ->orWhere('provider_id', $userID)
            ->orderby('scheduled_at')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)->get();
        return view('bookings.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id'      => 'required|exists:users,id|different:requester_id_placeholder',
            'scheduled_at'     => 'required|date|after:now',
            'duration_minutes' => 'required|integer|in:30,60,90',
            'notes'            => 'nullable|string|max:500',
        ]);

        if ((int) $request->provider_id === $request->user()->id) {
            return back()->withErrors(['provider_id' => 'You cannot book a session with yourself.']);
        }

        $conflict = Booking::where('provider_id', $request->provider_id)
            ->where('scheduled_at', $request->scheduled_at)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflict) {
            return back()->withErrors(['scheduled_at' => 'That time slot is already booked with this user.']);
        }

        Booking::create([
            'requester_id'     => $request->user()->id,
            'provider_id'      => $request->provider_id,
            'scheduled_at'     => $request->scheduled_at,
            'duration_minutes' => $request->duration_minutes,
            'notes'            => $request->notes,
            'status'           => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Session booked!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:confirmed,cancelled']);

        abort_unless(
            in_array($request->user()->id, [$booking->requester_id, $booking->provider_id]),
            403
        );

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking updated.');
    }
}
