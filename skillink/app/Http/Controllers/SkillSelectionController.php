<?php

namespace App\Http\Controllers;

use App\Models\SkillOffering;
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
}
