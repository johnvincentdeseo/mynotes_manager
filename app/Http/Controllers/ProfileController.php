<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\SupportStyle;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB limit
        ]);

        
        if ($request->hasFile('profile_picture')) {
            
            
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            
            $path = $request->file('profile_picture')->store('avatars', 'public');

            
            $validated['profile_picture'] = $path;
        }

        
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
