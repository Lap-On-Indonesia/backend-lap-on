<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisterOwnerMarketplace;

class CheckOwnerMarketplace
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = RegisterOwnerMarketplace::where('email', Auth::user()->email)->first();
            if (!$user) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'You must register as an owner marketplace before logging in.']);
            }
        }

        return $next($request);
    }
}
