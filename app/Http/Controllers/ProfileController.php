<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        // 1. Validation
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'           => 'nullable|string|max:20',
            'gender'          => 'nullable|string',
            'address'         => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Handle Profile Picture (Ligtas para sa Railway Production)
        if ($request->hasFile('profile_picture')) {
            // Burahin ang lumang picture kung mayroon gamit ang Storage facade
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // I-store ang file gamit ang default storage engine sa 'avatars' folder
            // Gagamitin nito ang relative storage system na mas preferred ng web servers
            $path = $request->file('profile_picture')->store('avatars', 'public');
            
            // Ito ang ise-save sa db: "avatars/filename.jpg"
            $validated['profile_picture'] = $path;
        }

        // 3. Handle Password
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // 4. Update User
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
