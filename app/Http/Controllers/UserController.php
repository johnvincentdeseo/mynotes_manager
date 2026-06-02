<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('management.users', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:user,admin', // Validates incoming role selector
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'], // Saves the chosen role from modal
        ]);

        return redirect()->route('users.index')->with('toast_success', 'User added successfully!');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:user,admin', // Validates role change updates
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role']; // <--- THIS LINE WAS MISSING. This saves it to the DB!

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('toast_success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('toast_error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('toast_success', 'User deleted successfully!');
    }
}