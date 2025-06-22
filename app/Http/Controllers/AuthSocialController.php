<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AuthSocialController extends Controller
{
  public function redirectToGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  public function handleGoogleCallback()
  {
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if ($user && !$user->google_id) {
      return redirect()->route('login')->with('error', 'Este email ya está registrado. Inicia sesión manualmente.');
    }

    $user = User::updateOrCreate(
      ['email' => $googleUser->getEmail()],
      [
        'google_id' => $googleUser->getId(),
        'name' => $googleUser->getName(),
        'avatar' => $googleUser->getAvatar(),
      ]
    );

    Auth::login($user);
    return redirect()->intended('/dashboard');
  }
}
