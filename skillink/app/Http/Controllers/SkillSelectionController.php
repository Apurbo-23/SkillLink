<?php

namespace App\Http\Controllers;

use App\Models\SkillOffering;
use App\Models\User;
use Illuminate\Http\Request;

class SkillSelectionController extends Controller
{
    public function index(Request $request)
    {
        $offerings = SkillOffering::with('attachments')
            ->where('user_id', $request->user()->id)
            ->get();

        return view('skillselection', compact('offerings'));
    }

    /**
     * Search for users by skill offering
     */
    public function search(Request $request)
    {
        $category = $request->query('category');
        $skill = $request->query('skill');
        $skill = $skill ? trim($skill) : null;

        $results = collect();

        // If skill is provided, search
        if ($skill) {
            $query = User::whereHas('skillOfferings', function ($query) use ($category, $skill) {
                $query->where('skill_name', 'LIKE', '%' . $skill . '%');
                
                // Only filter by category if provided
                if ($category && $category !== '') {
                    $query->where('category', $category);
                }
            })
            ->where('id', '!=', $request->user()->id)
            ->with(['skillOfferings', 'ratingsReceived']);

            $results = $query->paginate(12);
        }

        return view('search-skills', [
            'results' => $results,
            'selectedCategory' => $category,
            'selectedSkill' => $skill,
        ]);
    }
}
