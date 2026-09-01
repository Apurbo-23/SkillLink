<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminDebugController extends Controller
{
    public function checkAdmin()
    {
        $admin = User::where('email', 'admin@admin.io')->first();
        
        if (!$admin) {
            return response()->json(['error' => 'Admin user not found'], 404);
        }

        return response()->json([
            'found' => true,
            'name' => $admin->name,
            'email' => $admin->email,
            'is_admin' => $admin->is_admin,
            'email_verified_at' => $admin->email_verified_at,
            'created_at' => $admin->created_at,
        ]);
    }
}
