<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
  public string $email = '';

  /**
   * Send a password reset link to the provided email address.
   */
  public function sendPasswordResetLink(): void
  {
    $this->validate([
      'email' => ['required', 'string', 'email'],
    ], [
      'email.required' => 'El campo de correo electrónico es obligatorio.',
      'email.string'   => 'El correo electrónico debe ser una cadena de texto.',
      'email.email'    => 'Debes proporcionar una dirección de correo electrónico válida.',
    ]);

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink(
      $this->only('email')
    );

    if ($status === Password::INVALID_USER) {
      $this->addError('email', 'No encontramos un usuario registrado con este correo electrónico.');
      return;
    }

    if ($status != Password::RESET_LINK_SENT) {
      $this->addError('email', __($status));
      return;
    }

    $this->reset('email');

    session()->flash('status', '¡Listo! Te hemos enviado un enlace para restablecer tu contraseña.');
  }
}; ?>

<div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
  {{-- <a href="{{ url('/') }}" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
    <img src="{{ asset('images/logo.png') }}" class="mr-4 h-20" alt="logo">
  </a> --}}
  <!-- Card -->
  <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800">
    <div class="w-full p-6 sm:p-8">
      <h2 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">
        ¿Olvidaste su contraseña?
      </h2>
      <p class="text-base font-normal text-gray-500 dark:text-gray-400 text-justify">
        Proporciona tu correo y te enviaremos un enlace para restablecer tu contraseña.
      </p>
      <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
          {{ session('status') }}
        </div>
      @endif

      <form wire:submit="sendPasswordResetLink" class="mt-8 space-y-6">
        <!-- Email Address -->
        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
          <input wire:model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="nombre@gmail.com" autofocus>
          @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Restablecer contraseña</button>
      </form>
    </div>
  </div>
</div>
