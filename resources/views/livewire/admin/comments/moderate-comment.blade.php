<div>
  <!-- Modal -->
  <div 
    x-data="{ isModalOpen: @entangle('isModalOpen') }"
    x-show="isModalOpen" 
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <!-- Modal container -->
    <div class="relative w-full max-w-md p-4 mx-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div class="flex justify-end p-2">
          <button 
            type="button" 
            wire:click="closeModalModerate" 
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
          </button>
        </div>
        
        <!-- Modal body -->
        <div class="p-6 pt-0 text-center">
          @if($action === 'approve')
            <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-5 mb-2 text-lg font-semibold text-gray-900 dark:text-white">Aprobar comentario</h3>
            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
              "{{ $commentPreview }}"
            </p>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
              ¿Estás seguro de que deseas aprobar este comentario?
            </p>
          @else
            <svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-5 mb-2 text-lg font-semibold text-gray-900 dark:text-white">Rechazar comentario</h3>
            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
              "{{ $commentPreview }}"
            </p>
            
            <!-- Campo de razón solo para rechazo -->
            <div class="mb-6 text-left">
              <label for="reason" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                Razón del rechazo: <span class="text-red-500">*</span>
              </label>
              <textarea 
                wire:model="reason"
                id="reason"
                rows="3" 
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 @error('reason') border-red-500 @enderror" 
                placeholder="Ej: Contenido ofensivo, lenguaje inapropiado, spam..."></textarea>
              @error('reason')
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Mínimo 10 caracteres, máximo 200.
              </p>
            </div>
          @endif
          
          <button 
            type="button" 
            wire:click="moderateComment" 
            class="text-white {{ $action === 'approve' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-300' : 'bg-red-600 hover:bg-red-800 focus:ring-red-300' }} focus:ring-4 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-{{ $action === 'approve' ? 'green' : 'red' }}-800">
            {{ $action === 'approve' ? 'Sí, aprobar' : 'Sí, rechazar' }}
          </button>
          <button 
            type="button" 
            wire:click="closeModalModerate" 
            class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            No, cancelar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>