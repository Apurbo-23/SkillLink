<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Listing::where('status', 'active')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('categories.index', compact('categories'));
    }

    public function show($category)
    {
        $listings = Listing::where('status', 'active')
            ->where('category', $category)
            ->with('user')
            ->latest()
            ->get();

        return view('categories.show', compact('category', 'listings'));
    }
}
