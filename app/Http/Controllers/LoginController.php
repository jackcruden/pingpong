<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $github = Socialite::driver('github')->user();

        $token = $github->token;
        $refreshToken = $github->refreshToken; // not always provided
        $expiresIn = $github->expiresIn;

        // Check if user exists
        $user = User::findByEmail($github->getEmail());
        if (! $user) {
            $user = User::forceCreate([
                'github_id' => $github->getId(),
                'name' => Str::words($github->getName(), 1, ''),
                'email' => $github->getEmail(),
                'profile_photo_path' => $github->getAvatar(),
                'email_verified_at' => now(),
            ]);

            $team = Team::forceCreate([
                'user_id' => $user->getKey(),
                'name' => $user->name."'s Team",
                'personal_team' => true,
            ]);

            $user->forceFill([
                'current_team_id' => $team->id,
            ]);
        }

        Auth::login($user, true);

        return redirect('/dashboard');
    }
}
