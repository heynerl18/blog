<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
  public LoginForm $form;

  /**
   * Handle an incoming authentication request.
   */
  public function login(): void
  {
    $this->validate();
    $this->form->authenticate();
    Session::regenerate();

    $user = auth()->user();

    if($user && $user->hasAnyRole(['Admin', 'Blogger'])){
      $this->redirect(route('admin.dashboard'), navigate: false);
      return;
    }
    // Normal user
    $this->redirectIntended(default: route('public.home'), navigate: false);
  }

}; ?>

<section class="bg-gray-50 dark:bg-gray-900 min-h-screen">
  <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto min-h-screen">
    <!-- Logo -->
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
      <img class="w-20 h-16 sm:w-25 sm:h-20 mr-2" src="{{ asset('images/logo.png') }}" alt="logo">
    </a>
    
    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
      <div class="p-4 sm:p-8 space-y-4 sm:space-y-6">
        <h1 class="text-lg sm:text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white text-center">
          Inicia sesión en tu cuenta
        </h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if (session('error'))
          <div class="mb-4 text-sm text-red-600 bg-red-50 dark:bg-red-900/20 p-3 rounded-md">
            {{ session('error') }}
          </div>
        @endif

        <form wire:submit="login" class="space-y-4 sm:space-y-6">
          <!-- Email Address -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Correo electrónico
            </label>
            <input 
              wire:model="form.email" 
              type="email" 
              name="email" 
              id="email" 
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
              placeholder="Ingresa tu correo" 
              autofocus 
              autocomplete="username"
            >
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
          </div>

          <!-- Password -->
          <div x-data="{ showPassword: false }">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Contraseña
            </label>
            <div class="relative">
              <input 
                wire:model="form.password" 
                :type="showPassword ? 'text' : 'password'" 
                name="password" 
                id="password" 
                placeholder="••••••••" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 pr-12 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                autocomplete="current-password"
              >
              <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none"
              >
                <!-- Eye closed icon -->
                <svg x-show="!showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                  <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                </svg>

                <!-- Eye open icon -->
                <svg x-show="showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between text-sm">
            <div class="flex items-center">
              <input 
                wire:model="form.remember" 
                id="remember" 
                type="checkbox" 
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
              >
              <label for="remember" class="ml-2 text-gray-500 dark:text-gray-300">
                Recuérdame
              </label>
            </div>

            <!-- Forgot Password -->
            @if(Route::has('password.request'))
              <a 
                href="{{ route('password.request') }}" 
                class="text-primary-600 hover:underline dark:text-primary-500 font-medium" 
                wire:navigate
              >
                ¿Olvidó su contraseña?
              </a>
            @endif
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors"
          >
            Ingresar
          </button>
        </form>

        <!-- Separator -->
        <div class="flex items-center my-4 sm:my-6">
          <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
          <span class="mx-3 text-sm text-gray-500 dark:text-gray-400">O inicia sesión con</span>
          <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
        </div>

        <!-- Social Login Button -->
        <div class="w-full">
          <a 
            href="{{ route('auth.redirect') }}" 
            class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
          >
            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-2">
            Google
          </a>
        </div>

        <!-- Register Link -->
        @if(Route::has('register'))
          <p class="text-sm text-center text-gray-500 dark:text-gray-400">
            ¿No tienes una cuenta aún?
            <a 
              href="{{ route('register') }}" 
              class="font-medium text-primary-600 hover:underline dark:text-primary-500 ml-1" 
              wire:navigate
            >
              Regístrate
            </a>
          </p>
        @endif
      </div>
    </div>
  </div>
</section>