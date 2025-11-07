<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            // mark new users as verified so email verification is not required
            'email_verified_at' => now(),
        ]);

        return response()->json(['user' => $user]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            if ($request->expectsJson()) {
                throw ValidationException::withMessages(['name' => ['Invalid credentials']]);
            }
            
            return back()->withErrors([
                'name' => 'The provided credentials do not match our records.',
            ])->onlyInput('name');
        }

        // For API requests, return JSON with token
        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user]);
        }

        // For web requests, log in the user and redirect to dashboard
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showLogin()
    {
        return view('auth.login'); // or whatever your login view is named
    }


    public function logout(Request $request)
    {
        $wasLoggedIn = Auth::check();
        $username = $wasLoggedIn ? Auth::user()->name : null;

        // Delete tokens before logout
        if ($wasLoggedIn && $request->user()) {
            $request->user()->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('auth.logout', [
            'wasLoggedIn' => $wasLoggedIn,
            'username' => $username ? $username : 'User',
        ]);
    }
}


