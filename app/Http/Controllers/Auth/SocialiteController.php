<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Agar user pehle se email se registered hai ya pehle Google se login kiya hai
            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                // Naye user ke liye random password, existing ke liye wahi rahega
                'password' => $googleUser->password ?? bcrypt(Str::random(16)),
            ]);

            Auth::login($user);

            // Admin hai toh admin dashboard, varna user profile
            return $user->is_admin ? redirect('/user/products') : redirect('/profile');
        } catch (\Exception $e) {
            return redirect('/user/login')->with('error', 'Google Login Failed!');
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
}
