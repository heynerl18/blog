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

    //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    $this->redirect(route('dashboard', absolute: false));
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

        <form wire:submit="login" class="space-y-4 md:space-y-6">
          <!-- Email Address -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
            <input wire:model="form.email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingresa su correo" autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
            <input wire:model="form.password" type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="current-password">
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
          <button type="button" class="flex items-center justify-center w-full px-4 py-2 border-[0.5px] border-gray-300 dark:border-gray-600        rounded-md shadow-sm text-sm    font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5 mr-2">
            Google
          </button>
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

