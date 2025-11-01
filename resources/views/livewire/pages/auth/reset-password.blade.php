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
      'token.required'     => 'El token es requerido.',
      'email.required'     => 'El correo electrónico es requerido.',
      'email.string'       => 'El correo electrónico debe ser una cadena de texto.',
      'email.email'        => 'El correo electrónico debe ser una dirección válida.',
      'password.required'  => 'El campo de contraseña es requerido.',
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

<section class="bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ showPassword: false, showPasswordConfirm: false }">
  <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto min-h-screen">
    
    <!-- Reset Password Card with Overlapping Logo -->
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
          <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white text-center -mt-2">
            Restablece tu contraseña
          </h2>
          
          <form wire:submit.prevent="resetPassword" class="space-y-6">
            <!-- Email -->
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
                autocomplete="email"
                wire:loading.attr="disabled"
              >
              @error('email') 
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Nueva contraseña
              </label>
              <div class="relative">
                <input 
                  wire:model="password" 
                  :type="showPassword ? 'text' : 'password'" 
                  name="password" 
                  id="password" 
                  placeholder="••••••••" 
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 pr-12 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                  autocomplete="new-password"
                  wire:loading.attr="disabled"
                >
                <button 
                  type="button" 
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none disabled:opacity-50"
                  wire:loading.attr="disabled"
                >
                  <svg x-show="!showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                  </svg>
                  
                  <svg x-show="showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
              @error('password') 
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Confirmar nueva contraseña
              </label>
              <div class="relative">
                <input 
                  wire:model="password_confirmation" 
                  :type="showPasswordConfirm ? 'text' : 'password'" 
                  name="password_confirmation" 
                  id="password_confirmation" 
                  placeholder="••••••••" 
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 pr-12 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                  autocomplete="new-password"
                  wire:loading.attr="disabled"
                >
                <button 
                  type="button" 
                  @click="showPasswordConfirm = !showPasswordConfirm"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none disabled:opacity-50"
                  wire:loading.attr="disabled"
                >
                  <svg x-show="!showPasswordConfirm" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                  </svg>
                  
                  <svg x-show="showPasswordConfirm" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
              @error('password_confirmation') 
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
              <span wire:loading.remove wire:target="resetPassword">
                Restablecer contraseña
              </span>
              
              <!-- Spinner y texto de carga -->
              <span wire:loading wire:target="resetPassword" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Restableciendo...
              </span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>