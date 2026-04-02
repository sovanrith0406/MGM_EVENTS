<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ── LOGIN METHODS ─────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find user by email column
        $user = User::where('email', $request->username)->first();

        // Verify password against password_hash column
        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()
                ->withErrors(['username' => 'Invalid email or password.'])
                ->withInput();
        }

        // Check account is active (is_active = 1)
        if (!$user->is_active) {
            return back()
                ->withErrors(['username' => 'Your account has been deactivated.'])
                ->withInput();
        }

        // Login and regenerate session
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    // ── REGISTRATION METHODS ──────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('backend.auth.register'); 
    }

    public function register(Request $request)
    {
        // 1. Validate the form data (Notice we DO NOT validate role_id here)
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'terms'     => 'accepted' // Ensures the checkbox was checked
        ]);

        // 2. Handle optional Avatar Upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            // Validating the image specifically if it's uploaded
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // 3. Create the new user
        $user = User::create([
            'full_name'     => $request->full_name,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), 
            'role_id'       => 3, // SECURE: Hardcoded to Supplier role
            'is_active'     => 1, // Active by default
            'avatar_url'    => $avatarPath, // Save the path if an image was uploaded
        ]);

        // 4. Log the user in immediately after registration
        Auth::login($user);
        $request->session()->regenerate();

        // 5. Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Supplier Registration successful!');
    }

    // ── LOGOUT METHOD ─────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}