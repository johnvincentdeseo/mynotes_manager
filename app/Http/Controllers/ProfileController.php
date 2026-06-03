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

        // 2. Handle Profile Picture (Direkta sa totoong Public Folder)
        if ($request->hasFile('profile_picture')) {
            // Burahin ang lumang picture sa public/avatars folder kung mayroon
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }
            
            // Gumawa ng kakaibang pangalan para sa file
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // I-move nang direkta sa public/avatars folder ng iyong app
            $file->move(public_path('avatars'), $filename);
            
            // I-save ang relative path sa database ('avatars/filename.jpg')
            $validated['profile_picture'] = 'avatars/' . $filename;
        }

        // 3. Handle Password (hiwalay para safe)
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
