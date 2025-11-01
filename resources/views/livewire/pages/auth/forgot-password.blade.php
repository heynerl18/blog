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
      'email.required' => 'Este campo es requerido.',
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

<section class="bg-gray-50 dark:bg-gray-900 min-h-screen">
  <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto min-h-screen">
    
    <!-- Forgot Password Card with Overlapping Logo -->
    <div class="w-full max-w-md relative">
      <!-- Logo positioned above the card -->
      <div class="flex justify-center mb-[-40px] relative z-10">
        <div class="bg-white dark:bg-gray-700 rounded-full p-2 shadow-lg border-4 border-primary-600 dark:border-primary-500">
          <img class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-contain" src="{{ asset('images/logo.png') }}" alt="logo">
        </div>
      </div>
      <!-- Card form -->
      <div class="bg-white rounded-lg shadow-xl dark:border dark:bg-gray-800 dark:border-gray-700 pt-12">
        <div class="p-4 sm:p-8 space-y-4 sm:space-y-6">
          <div class="-mt-2">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white text-center mb-3">
              ¿Olvidaste tu contraseña?
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
              Proporciona tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>
          </div>
          
          <!-- Session Status -->
          @if (session('status'))
            <div class="p-4 text-sm font-medium text-green-600 bg-green-50 rounded-lg dark:bg-green-900/20 dark:text-green-400">
              {{ session('status') }}
            </div>
          @endif

          <form wire:submit.prevent="sendPasswordResetLink" class="space-y-6">
            <!-- Email Address -->
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Correo electrónico
              </label>
              <input 
                wire:model="email" 
                type="email" 
                name="email" 
                id="email" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed" 
                placeholder="nombre@gmail.com" 
                autofocus
                autocomplete="email"
                wire:loading.attr="disabled"
              >
              @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors disabled:opacity-70 disabled:cursor-not-allowed relative"
              wire:loading.attr="disabled"
            >
              <!-- Texto normal -->
              <span wire:loading.remove wire:target="sendPasswordResetLink">
                Enviar enlace de restablecimiento
              </span>
              
              <!-- Spinner y texto de carga -->
              <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
              </span>
            </button>

            <!-- Back to Login Link -->
            <div class="text-sm text-center text-gray-500 dark:text-gray-400">
              <a 
                href="{{ route('login') }}" 
                class="font-medium text-primary-600 hover:underline dark:text-primary-500 inline-flex items-center gap-1" 
                wire:navigate
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio de sesión
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>