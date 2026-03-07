<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Socialite;
use Throwable;

class OAuthGoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with([
                'hd' => 'nemsu.edu.ph',
                'prompt' => 'select_account consent',
            ])
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')
                ->with(['hd' => 'nemsu.edu.ph'])
                ->user();

            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->email,
                ],
                [
                    'name' => $googleUser->name,
                    'avatar' => $googleUser->avatar,
                ]
            );

            $user->socialAccounts()->updateOrCreate(
                [
                    'provider' => 'google',
                    'provider_user_id' => $googleUser->id,
                ],
                [
                    'provider_token' => $googleUser->token,
                    'provider_refresh_token' => $googleUser->refreshToken,
                ]
            );

            Auth::login($user, remember: true);

            return redirect()->intended('/dashboard');
        } catch (Throwable $e) {
            Log::error('Google login failed: '.$e->getMessage());

            return redirect('/login')->with('error', 'Google login failed.');
        }
    }
}
