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
     * Display login page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 🔐 proses autentikasi Laravel Breeze
        $request->authenticate();

        // 🔄 regenerate session (security)
        $request->session()->regenerate();

        // 👤 ambil user login
        $user = Auth::user();

        // 🚀 ROLE-BASED REDIRECT
        if ($user->hasRole('admin')) {
            return redirect('/admin');
        }

        if ($user->hasRole('driver')) {
            return redirect('/driver/dashboard');
        }

        return redirect('/customer/dashboard');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}