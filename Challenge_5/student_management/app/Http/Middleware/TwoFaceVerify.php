<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFaceVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $secretCode = auth()->user()->google2fa_secret;

        if ($secretCode && !session('2fa_verified')) {
            return redirect()->route('2fa.verify.index');
        }
        return $next($request);
    }
}
