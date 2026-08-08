<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::with('user')
            ->where('status', 'open')
            ->latest()
            ->get();

        return view('listings.index', compact('listings'));
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_offered' => 'required|string|max:255',
            'skill_wanted'  => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'description'   => 'nullable|string|max:1000',
        ]);

        Listing::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'status'  => 'open',
        ]);

        return redirect()->route('listings.index')->with('success', 'Listing posted!');
    }
}