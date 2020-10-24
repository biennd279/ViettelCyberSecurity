<?php


namespace App\Providers;


use App\Models\SocialAccount;
use Laravel\Socialite\Contracts\User;

class FacebookAccountService
{
    public static function createOrGetUser(User $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = \App\Models\User::whereEmail($providerUser->getEmail())
                ->first();

            if (!$user) {
                $user = \App\Models\User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => 'password',
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
