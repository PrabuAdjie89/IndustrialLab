<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $email = strtolower($googleUser->getEmail());

            // Hanya izinkan domain UMS
            $isDosen = str_ends_with($email, '@ums.ac.id');
            $isMahasiswa = str_ends_with($email, '@student.ums.ac.id');

            if (!$isDosen && !$isMahasiswa) {
                return redirect('/login')
                    ->with('error', 'Hanya akun UMS yang diperbolehkan.');
            }

            $user = User::updateOrCreate(
                [
                    'email' => $email
                ],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(32)),
                    'email_verified_at' => now(),
                ]
            );

            // Pastikan user dianggap sudah verifikasi email
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            Auth::login($user, true);

            return redirect()->route('home');

        } catch (\Exception $e) {

            return redirect('/login')
                ->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}