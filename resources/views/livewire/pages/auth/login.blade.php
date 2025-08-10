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

<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
      <img class="w-25 h-20 mr-2" src="{{ asset('images/logo.png') }}" alt="logo">
    </a>
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Inicia sesión en tu cuenta
        </h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if (session('error'))
          <div class="mb-4 text-sm text-red-600">
            {{ session('error') }}
          </div>
        @endif

        <form wire:submit="login" class="space-y-4 md:space-y-6">
          <!-- Email Address -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
            <input wire:model="form.email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingresa su correo" autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
          </div>

          <!-- Password -->
          <div x-data="{ showPassword: false }">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
            <div class="relative">
              <input 
                wire:model="form.password" 
                :type="showPassword ? 'text' : 'password'" 
                name="password" 
                id="password" 
                placeholder="••••••••" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                autocomplete="current-password"
              >
              <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100"
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
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
          </div>

          <!-- Remember Me -->
          <div class="flex items-center justify-between">
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input wire:model="form.remember" id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
              </div>
              <div class="ml-3 text-sm">
                <label for="remember" class="text-gray-500 dark:text-gray-300">Recuérdame</label>
              </div>
            </div>

            <!-- Forgot Password -->
            @if(Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" wire:navigate>¿Olvidó su contraseña?</a>
            @endif
          </div>

          <!-- Submit Button -->
          <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Ingresar</button>
        </form>

        <!-- Separator -->
        <div class="flex items-center my-6">
          <div class="flex-grow border-t border-gray-300"></div>
          <span class="mx-4 text-gray-500">O inicia sesión con</span>
          <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Social Login Buttons -->
        <div class="flex justify-center gap-4">
          <a href="{{ route('auth.redirect') }}" class="flex items-center justify-center w-full px-4 py-2 border-[0.5px] border-gray-300 dark:border-gray-600        rounded-md shadow-sm text-sm    font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-2">
            Google
        </a>
        </div>

        <!-- Register Link -->
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
          @if(Route::has('register'))
            ¿No tienes una cuenta aún?
            <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500" wire:navigate>Regístrate</a>
          @endif
        </p>
      </div>
    </div>
  </div>
</section>