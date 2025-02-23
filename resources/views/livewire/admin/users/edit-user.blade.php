<div x-data="{ isModalOpen: @entangle('isModalOpen') }" x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
  <div class="relative w-full max-w-2xl p-4">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
      <!-- Modal header -->
      <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
        <h3 class="text-xl font-semibold dark:text-white">Asignar un rol</h3>
        <button type="button" wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <!-- Modal body -->
      <div class="p-6 space-y-6">
        <form wire:submit.prevent="save">
          <div class="grid grid-cols-1 gap-6">
            <div>
              <label for="category-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
              <!-- Input -->
              <input type="text" wire:model="name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nombre de usuario">
              <h5 class="mt-3 mb-1 text-sm font-medium text-gray-900 dark:text-white">Lista de roles</h5>
              @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
              @enderror
              @foreach($roles as $role)
                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}" wire:model="selectedRoles" class="mr-1 w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="role-{{ $role->id }}" class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</label>
                  </div>
                </div>
              @endforeach
              <div class="mt-4">
                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Asignar rol</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
