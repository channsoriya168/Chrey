<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    // Show login page
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    // Show register page
    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    // Handle registration
    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // assign default role if roles are available
        if (method_exists($user, 'assignRole')) {
            try {
                $user->assignRole('user');
            } catch (\Exception $e) {
                // ignore if role doesn't exist yet
            }
        }

        Auth::login($user);

        return redirect()->route('home');
    }

    // Handle login
    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            dd(User::with('roles')->find(auth()->id()));
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('dashboard.index');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
