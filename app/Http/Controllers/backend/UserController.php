<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->latest()->paginate(10);
        $roles = Role::all();

        return view('backend.user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('backend.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:120',
            'email'     => 'required|email|unique:users,email',
            'role_id'   => 'required|exists:roles,role_id',
            'password'  => 'required|min:6|confirmed',
            'avatar'    => 'nullable|image|max:2048',
        ]);

        $data = [
            'full_name'     => $request->full_name,
            'email'         => $request->email,
            'role_id'       => $request->role_id,
            'password_hash' => Hash::make($request->password),
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar_url'] = $request->file('avatar')
                                          ->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backend.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:120',
            'email'     => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'role_id'   => 'required|exists:roles,role_id',
            'password'  => 'nullable|min:6|confirmed',
            'avatar'    => 'nullable|image|max:2048',
        ]);

        $data = [
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $data['avatar_url'] = $request->file('avatar')
                                          ->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}