<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $mostOffered = Listing::where('status', 'open')
            ->select('skill_offered', DB::raw('COUNT(*) as total'))
            ->groupBy('skill_offered')
            ->orderByDesc('total')
            ->get();

        $mostWanted = Listing::where('status', 'open')
            ->select('skill_wanted', DB::raw('COUNT(*) as total'))
            ->groupBy('skill_wanted')
            ->orderByDesc('total')
            ->get();

        return view('analytics.index', compact('mostOffered', 'mostWanted'));
    }
}
