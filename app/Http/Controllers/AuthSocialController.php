<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthSocialController extends Controller
{
  public function redirectToGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  public function handleGoogleCallback()
  {
    try {
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
          'email_verified_at' => now(),
        ]
      );

      Auth::login($user);

      return $this->redirectUserAfterLogin($user);
    } catch (\Exception $e) {
      return redirect()->route('login')->with('error', 'Error al autenticar con Google. Intenta de nuevo.');
    }
  }

  /**
   * Redirect the user based on their role after login.
   */
  protected function redirectUserAfterLogin($user)
  {
    if($user->hasAnyRole(['Admin', 'Blogger'])) {
      return redirect()->intended(route('admin.dashboard'));
    }
    return redirect()->intended(route('public.home'));
  }
}
