<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
  public string $name = '';
  public string $email = '';
  public string $password = '';
  public string $password_confirmation = '';

  /**
   * Handle an incoming registration request.
   */
  public function register(): void
  {
    $validated = $this->validate([
      'name' => ['required', 'string','min:4', 'max:10'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
      'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
      'password_confirmation' => ['required', 'string', 'min:8'],
    ]);

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);
    session()->flash('message', '¡Bienvenido! Tu cuenta ha sido creada exitosamente.');
    $this->redirect(route('public.home'));
  }

  protected function messages()
  {
    return [
      'name.required' => 'El campo nombre es requerido.',
      'name.string'   => 'El nombre debe ser una cadena de texto.',
      'name.max'      => 'El nombre no debe exceder los 10 caracteres.',
      'name.min'      => 'El nombre debe tener al menos 4 caracteres.',

      'email.required' => 'El campo correo electrónico es requerido.',
      'email.string'   => 'El correo electrónico debe ser una cadena de texto.',
      'email.email'    => 'El correo electrónico debe tener un formato válido.',
      'email.max'      => 'El correo electrónico no debe exceder los 255 caracteres.',
      'email.unique'   => 'El correo electrónico ya está en uso.',

      'password.required' => 'El campo contraseña es requerido.',
      'password.string'   => 'La contraseña debe ser una cadena de texto.',
      'password.confirmed' => 'La confirmación de la contraseña no coincide.',
      'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',

      'password_confirmation.required' => 'El campo confirmar contraseña es requerido.',
      'password_confirmation.string'   => 'La confirmación de la contraseña debe ser una cadena de texto.',
      'password_confirmation.min'      => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
    ];
  }
}; ?>

<section class="bg-gray-50 dark:bg-gray-900" x-data="{ showPassword: false, showPasswordConfirm: false }">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    {{-- <a href="#" class="flex items-center mb-2 text-2xl font-semibold text-gray-900 dark:text-white">
      <img class="w-25 h-20 mr-2" src="{{ asset('images/logo.png') }}" alt="logo">
    </a> --}}
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Crear una cuenta
        </h1>
        
        <form wire:submit="register" class="space-y-4 md:space-y-6">

          <!-- Name -->
          <div>
            <label for="name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input wire:model="name" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingresa su nombre" autofocus autocomplete="name">
            @error('name')
              <x-input-error :messages="$message" class="mt-1" />
            @enderror
          </div>

          <!-- Email Address -->
          <div>
            <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
            <input wire:model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingresa su correo" autocomplete="username">
            @error('email')
              <x-input-error :messages="$message" class="mt-1" />
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
            <div class="relative">
              <input 
                wire:model="password" 
                :type="showPassword ? 'text' : 'password'" 
                name="password" 
                id="password" 
                placeholder="••••••••" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                autocomplete="new-password"
              >
              <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100"
              >
                <!-- Ojo cerrado -->
                <svg x-show="!showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                  <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                </svg>
                
                <!-- Ojo abierto -->
                <svg x-show="showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
            @error('password')
              <x-input-error :messages="$message" class="mt-1" />
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmar Contraseña</label>
            <div class="relative">
              <input 
                wire:model="password_confirmation" 
                :type="showPasswordConfirm ? 'text' : 'password'" 
                name="password_confirmation" 
                id="password_confirmation" 
                placeholder="••••••••" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                autocomplete="new-password"
              >
              <button 
                type="button" 
                @click="showPasswordConfirm = !showPasswordConfirm"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100"
              >
                <!-- Ojo cerrado -->
                <svg x-show="!showPasswordConfirm" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                  <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                </svg>
                
                <!-- Ojo abierto -->
                <svg x-show="showPasswordConfirm" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
            @error('password_confirmation')
              <x-input-error :messages="$message" class="mt-1" />
            @enderror
          </div>

          <!-- Submit Button -->
          <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Registrar</button>

          <!-- Login Link -->
          <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500" wire:navigate>Inicie sesión aquí</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>