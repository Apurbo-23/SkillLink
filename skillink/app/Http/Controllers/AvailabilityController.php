<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    protected $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    public function index(Request $request)
    {
        $selectedDays = $request->user()->availabilities()->pluck('day_of_week')->toArray();
        $days = $this->days;

        return view('availability.index', compact('selectedDays', 'days'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'days'   => 'array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        ]);

        $request->user()->availabilities()->delete();

        foreach ($validated['days'] ?? [] as $day) {
            $request->user()->availabilities()->create(['day_of_week' => $day]);
        }

        return back()->with('success', 'Availability updated.');
    }
}