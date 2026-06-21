<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Handle registration
     */
    public function store(Request $request): RedirectResponse
    {
        // 🔐 VALIDASI
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 👤 CREATE USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🎯 ASSIGN ROLE DEFAULT CUSTOMER
        $user->assignRole('customer');

        // 📢 EVENT REGISTERED
        event(new Registered($user));

        // 🔑 LOGIN AUTO
        Auth::login($user);

        // 🚀 REDIRECT KE DASHBOARD CUSTOMER
        return redirect('/customer/dashboard');
    }
}