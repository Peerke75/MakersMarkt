<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Get the login input value (username or email)
        $login = $request->input('username'); // This should work if you change the form field to 'username'

        // Check if the login input is an email or username
        $user = User::where('email', $login)
                    ->orWhere('username', $login)
                    ->first();

        if (!$user) {
            // If no user found, return an error
            return back()->withErrors([
                'username' => 'The provided credentials are incorrect.',
            ]);
        }

        // Check if the password matches
        if (Hash::check($request->password, $user->password)) {
            // If the user exists and the password matches, authenticate the user
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // If the password doesn't match
        return back()->withErrors([
            'username' => 'The provided credentials are incorrect.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
