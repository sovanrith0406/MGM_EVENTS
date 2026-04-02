<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{   
    public function index()
    {
        $user = Auth::user();
        return view('backend.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:120',
            'email'     => 'required|email|max:190|unique:users,email,' . $user->user_id . ',user_id',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);

        $user->full_name = $request->full_name;
        $user->email     = $request->email;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path;
        }

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password_hash = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')
                         ->with('success', 'Profile updated successfully.');
    }
}