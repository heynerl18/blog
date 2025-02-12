<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
  #[Validate('required|string|email')]
  public string $email = '';

  #[Validate('required|string|min:8')]
  public string $password = '';

  #[Validate('boolean')]
  public bool $remember = false;

  /**
   * Attempt to authenticate the request's credentials.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function authenticate(): void
  {
    $this->ensureIsNotRateLimited();

    if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        'form.email' => trans('auth.failed'),
      ]);
    }

    RateLimiter::clear($this->throttleKey());
  }

  protected function messages()
  {
    return [
      'email.required'    => 'El campo correo electrónico es obligatorio.',
      'email.string'      => 'El correo electrónico debe ser una cadena de texto.',
      'email.email'       => 'El campo email debe ser una dirección de correo válida.',
      'password.required' => 'El campo contraseña es obligatorio.',
      'password.string'   => 'La contraseña debe ser una cadena de texto.',
      'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
    ];
  }

  /**
   * Ensure the authentication request is not rate limited.
   */
  protected function ensureIsNotRateLimited(): void
  {
    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'form.email' => trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
   * Get the authentication rate limiting throttle key.
   */
  protected function throttleKey(): string
  {
    return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
  }
}
