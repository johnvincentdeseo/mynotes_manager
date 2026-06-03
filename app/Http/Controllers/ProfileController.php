<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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

        // 2. Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            // Burahin ang lumang picture kung mayroon
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // I-store sa 'avatars' folder sa loob ng public disk
            $path = $request->file('profile_picture')->store('avatars', 'public');
            $validated['profile_picture'] = $path;
        }

        // 3. Handle Password (hiwalay para safe)
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $validated['password'] = Hash::make($request->password);
        } else {
            // Tanggalin ang password sa $validated array para hindi ma-update ng null
            unset($validated['password']);
        }

        // 4. Update User
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
