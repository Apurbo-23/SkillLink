<?php

namespace App\Http\Controllers;

use App\Models\SkillOffering;
use App\Models\SkillOfferingAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillOfferingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'   => 'required|string|max:255',
            'skill_name' => 'required|string|max:255',
        ]);

        $offering = SkillOffering::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Skill added.')->with('offering_id', $offering->id);
    }

    public function uploadAttachment(Request $request, SkillOffering $skillOffering)
    {
        abort_unless($skillOffering->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('attachments', 'public'); // saves to storage/app/public/attachments

            SkillOfferingAttachment::create([
                'skill_offering_id' => $skillOffering->id,
                'type' => 'file',
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        } elseif ($request->filled('link')) {
            SkillOfferingAttachment::create([
                'skill_offering_id' => $skillOffering->id,
                'type' => 'link',
                'url' => $validated['link'],
            ]);
        } else {
            return back()->withErrors(['file' => 'Upload a file or provide a link.']);
        }

        return back()->with('success', 'Sample work added.');
    }

    public function deleteAttachment(Request $request, SkillOfferingAttachment $attachment)
    {
        abort_unless($attachment->skillOffering->user_id === $request->user()->id, 403);

        if ($attachment->path) {
            Storage::disk('public')->delete($attachment->path);
        }

        $attachment->delete();

        return back()->with('success', 'Attachment removed.');
    }
}