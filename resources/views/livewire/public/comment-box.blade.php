<div class="mt-12 mb-4">
  <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-4">Deja un comentario</h3>

  <form wire:submit.prevent="sendComment">
    <label for="comment" class="sr-only">Tu comentario</label>
    <div class="flex items-center px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700">
      <textarea wire:model.defer="comment" rows="1" id="comment" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Escribe tu comentario..."></textarea>
      <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
        <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 18 20"><path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/></svg>
      </button>
    </div>
    {{-- Displays the error message for the 'comment' field --}}
    @error('comment')
      <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
  </form>
</div>