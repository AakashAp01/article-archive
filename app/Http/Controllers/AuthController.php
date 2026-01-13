<?php

namespace App\Http\Controllers;

use App\Mail\DynamicTemplateMail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                ],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'type' => 'user'
                ]
            );

            Auth::login($user);
            
            if ($user->wasRecentlyCreated) {
                send_welcome_email($user);
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong during authentication.');
        }
    }

    /**
     * Handle Logout
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
