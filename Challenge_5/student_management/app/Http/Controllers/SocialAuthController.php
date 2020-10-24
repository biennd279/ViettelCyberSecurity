<?php

namespace App\Http\Controllers;

use App\Providers\FacebookAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $socialUser = Socialite::driver($social)->stateless()->user();
        $user = FacebookAccountService::createOrGetUser($socialUser);
        \Auth::login($user);
        return redirect()->to('/');
    }
}
