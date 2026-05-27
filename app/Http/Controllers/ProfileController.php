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

        // Validate text parameters along with image rules constraints
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB limit
        ]);

        // Process file stream logic only if a user uploads a new image package file
        if ($request->hasFile('profile_picture')) {
            
            // Delete the user's previous image asset file if one already exists to save disk storage space
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Save the newly uploaded file to standard secure public app directories
            // This creates a location inside your project like: storage/app/public/avatars/randomName.png
            $path = $request->file('profile_picture')->store('avatars', 'public');

            // Set the model parameter path string destination payload update link reference
            $validated['profile_picture'] = $path;
        }

        // Apply changes to database rows safely
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}