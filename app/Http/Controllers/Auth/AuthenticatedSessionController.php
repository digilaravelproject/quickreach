<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * ONLY ALLOWS ADMIN LOGIN
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // Authenticate the user
    //     $request->authenticate();

    //     // Check if user is admin
    //     if (!$request->user()->isAdmin()) {
    //         // If not admin, logout immediately
    //         Auth::guard('web')->logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();

    //         // Return with error message
    //         return back()->withErrors([
    //             'email' => 'Access denied. Admin credentials required.',
    //         ])->onlyInput('email');
    //     }

    //     // Regenerate session for security
    //     $request->session()->regenerate();

    //     // Redirect to admin dashboard with no-cache headers
    //     return redirect()
    //         ->intended(route('admin.dashboard'))
    //         ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
    //         ->header('Pragma', 'no-cache')
    //         ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Aapke model ka isAdmin() method use ho raha hai
        if ($request->user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.products'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page after logout
        return redirect()
            ->route('login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
