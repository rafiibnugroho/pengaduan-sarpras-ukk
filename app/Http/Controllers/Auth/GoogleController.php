<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // <-- penting
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google OAuth page
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['email', 'profile']) // FIXED: pakai scopes()
                ->redirect();
        } catch (Exception $e) {
            Log::error('Google Redirect Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek user by email
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Update google_id & avatar kalau belum ada
                if (!$existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar'    => $googleUser->getAvatar(),
                    ]);
                }

                Auth::login($existingUser, true);
                return redirect()->intended('/home')
                    ->with('success', 'Welcome back! You have successfully logged in with Google.');
            }

            // Buat user baru
            $newUser = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'password'          => Hash::make(Str::random(16)), // password random
                'email_verified_at' => now(), // auto verified
            ]);

            Auth::login($newUser, true);
            return redirect()->intended('/dashboard')
                ->with('success', 'Account created successfully! Welcome to our platform.');

        } catch (Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Something went wrong with Google authentication. Please try again.');
        }
    }

    /**
     * Unlink Google account dari user
     */
    public function unlinkGoogle(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user->password) {
                return back()->with('error', 'You must set a password before unlinking your Google account.');
            }

            $user->update([
                'google_id' => null,
                'avatar'    => null,
            ]);

            return back()->with('success', 'Google account has been unlinked successfully.');
        } catch (Exception $e) {
            Log::error('Unlink Google Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to unlink Google account. Please try again.');
        }
    }

    /**
     * Link existing account ke Google
     */
    public function linkGoogle()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['email', 'profile'])
                ->with(['state' => 'link_account'])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Link Google Redirect Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    /**
     * Handle linking Google ke account sekarang
     */
    public function handleGoogleLink()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = Auth::user();

            // Cek apakah google_id sudah dipakai user lain
            $existingGoogleUser = User::where('google_id', $googleUser->getId())
                ->where('id', '!=', $user->id)
                ->first();

            if ($existingGoogleUser) {
                return redirect()->route('profile.edit')
                    ->with('error', 'This Google account is already linked to another user.');
            }

            // Update ke user sekarang
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            return redirect()->route('profile.edit')
                ->with('success', 'Google account linked successfully!');
        } catch (Exception $e) {
            Log::error('Handle Google Link Error: ' . $e->getMessage());
            return redirect()->route('profile.edit')
                ->with('error', 'Unable to link Google account. Please try again.');
        }
    }
}
