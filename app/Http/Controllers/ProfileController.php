<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // 2. Handle Profile Picture (Ligtas para sa Railway Web Server Container)
        if ($request->hasFile('profile_picture')) {
            // Burahin ang lumang picture sa server kung nage-exist
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                @unlink(public_path($user->profile_picture));
            }
            
            $file = $request->file('profile_picture');
            // Gumawa ng malinis na unique filename gamit ang timestamp at user id
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // I-move nang direkta sa loob ng default public system path ng app mo
            $file->move(public_path('uploads'), $filename);
            
            // I-save ang relative layout path sa database (Tiyak na kasya sa VARCHAR 255)
            $validated['profile_picture'] = 'uploads/' . $filename;
        }

        // 3. Handle Password
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // 4. Update User Profile
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
