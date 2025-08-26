<section id="contact-section" class="py-5 lg:py-5 px-4 mx-auto max-w-screen-sm">

  <h2 class="mb-2 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Contáctanos</h2>
  <p class="mb-6 font-normal text-center text-gray-500 dark:text-gray-400 sm:text-lg">
    ¡Nos encantaría saber de ti! Déjanos saber lo que necesitas y te responderemos en breve.
  </p>

  @if ($successMessage)
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 text-center" role="alert">
      {{ $successMessage }}
    </div>
  @endif

  @if ($errorMessage)
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 text-center" role="alert">
      {{ $errorMessage }}
    </div>
  @endif

  <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-8 dark:bg-gray-800 dark:border-gray-700">
    <form wire:submit.prevent="submitForm" class="space-y-8">
      
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tu correo electrónico</label>
        <input type="email" id="email" wire:model.live="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="john.doe@company.com">
        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
      </div>

      <div>
        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Asunto</label>
        <input type="text" id="subject" wire:model.live="subject" class="block p-3 w-full text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Déjanos saber cómo podemos ayudarte">
        @error('subject') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
      </div>

      <div class="sm:col-span-2">
        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tu mensaje</label>
        <textarea id="message" rows="6" wire:model.live="message" class="block p-2.5 w-full text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe tu mensaje aquí..."></textarea>
        @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
      </div>

      <p class="text-sm text-gray-500 dark:text-gray-400">
        Al enviar este formulario, aceptas nuestros <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">Términos y Condiciones</a>
        y nuestra <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">Política de Privacidad</a>,
        que explica cómo podemos recopilar, usar y divulgar tu información personal, incluyendo a terceros.
      </p>

      <button type="submit" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 sm:w-fit hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="submitForm">Enviar Mensaje</span>
        <span wire:loading wire:target="submitForm">Enviando...</span>
      </button>
      
    </form>
  </div>
</section>
