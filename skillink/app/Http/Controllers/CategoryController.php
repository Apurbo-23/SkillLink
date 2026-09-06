<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Listing::where('status', 'open')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('categories.index', compact('categories'));
    }

    public function show($category)
    {
        $listings = Listing::where('status', 'open')
            ->where('category', $category)
            ->with('user')
            ->latest()
            ->get();

        return view('categories.show', compact('category', 'listings'));
    }
}
