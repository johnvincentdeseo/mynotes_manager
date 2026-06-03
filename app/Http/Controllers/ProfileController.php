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

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'           => 'nullable|string|max:20',
            'gender'          => 'nullable|string',
            'address'         => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->gender = $validated['gender'] ?? null;
        $user->address = $validated['address'] ?? null;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileData = file_get_contents($file->getRealPath());
            $base64 = 'data:image/' . $file->getClientOriginalExtension() . ';base64,' . base64_encode($fileData);
            $user->profile_picture = $base64;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('toast_success', 'Profile identity updated successfully.');
    }
}
