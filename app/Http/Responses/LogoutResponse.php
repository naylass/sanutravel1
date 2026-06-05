<?php

// app/Http/Responses/LogoutResponse.php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as ContractsLogoutResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LogoutResponse implements ContractsLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); 
    }
}