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

        // 2. Pure Native Local Upload (Base64 Encoding sa Database)
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            
            // Konvertihin ang file para maging text string code
            $fileData = file_get_contents($file->getRealPath());
            $base64 = 'data:image/' . $file->getClientOriginalExtension() . ';base64,' . base64_encode($fileData);
            
            $validated['profile_picture'] = $base64;
        }

        // 3. Handle Password
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // 4. Update User Data
        $user->update($validated);

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
