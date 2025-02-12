<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
  #[Locked]
  public string $token = '';
  public string $email = '';
  public string $password = '';
  public string $password_confirmation = '';

  /**
   * Mount the component.
   */
  public function mount(string $token): void
  {
    $this->token = $token;
    $this->email = request()->string('email');
  }

  /**
   * Reset the password for the given user.
   */
  public function resetPassword(): void
  {
    $this->validate([
      'token'    => ['required'],
      'email'    => ['required', 'string', 'email'],
      'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    ], [
      'token.required'     => 'El token es obligatorio.',
      'email.required'     => 'El correo electrónico es requerido.',
      'email.string'       => 'El correo electrónico debe ser una cadena de texto.',
      'email.email'        => 'El correo electrónico debe ser una dirección válida.',
      'password.required'  => 'El campo de contraseña es obligatorio.',
      'password.string'    => 'La contraseña debe ser una cadena de texto.',
      'password.confirmed' => 'La confirmación de la contraseña no coincide.',
      'password.min'       => 'La contraseña debe tener al menos :min caracteres.',
    ]);

    $status = Password::reset(
      $this->only('email', 'password', 'password_confirmation', 'token'),
      function ($user) {
        $user->forceFill([
          'password' => Hash::make($this->password),
          'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
      }
    );

    if ($status != Password::PASSWORD_RESET) {
      $this->addError('email', __($status));
      return;
    }

    Session::flash('status', '¡Contraseña restablecida! Inicia sesión.');
    $this->redirectRoute('login', navigate: true);
  }
}; ?>

<div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
  <a href="/" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
    <img src="{{ asset('images/logo.png') }}" class="mr-4 h-20" alt="logo">
  </a>
  <div class="w-full max-w-xl p-6 space-y-8 bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
      Restablece su contraseña
    </h2>
    <form wire:submit="resetPassword" class="mt-8 space-y-6">
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
        <input wire:model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="nombre@gmail.com">
        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>
      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nueva contraseña</label>
        <input wire:model="password" type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>
      <div>
        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar nueva contraseña</label>
        <input wire:model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        @error('password_confirmation') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>
      <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Restablecer contraseña</button>
    </form>
  </div>
</div>
