<div>
  <div 
    x-data="{ isModalOpen: @entangle('isModalOpen') }"
    x-show="isModalOpen" 
    @keydown.escape.window="$wire.closeModal()"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-2xl p-4">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
          <h3 class="text-xl font-semibold dark:text-white">
            {{ $roleId ? 'Editar Rol' : 'Crear Rol' }}
          </h3>
          <button type="button" wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>  
          </button>
        </div>
        
        <!-- Modal body -->
        <div class="p-6 space-y-6">
          <form wire:submit="save">
            <div class="grid grid-cols-1 gap-6">
              <div>
                <!-- Nombre del rol -->
                <label for="role-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Nombre del Rol <span class="text-red-500">*</span>
                </label>
                <input 
                  type="text"
                  id="role-name"
                  wire:model="name"
                  maxlength="10"
                  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder="Ingresa el nombre del rol"
                >
                @error('name')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
                
                <h3 class="mb-3 mt-4 text-lg font-semibold dark:text-white">Permisos (opcional)</h3>
                
                <div class="max-h-96 overflow-y-auto space-y-3">
                  @foreach($permissions as $module => $modulePermissions)
                    <div class="border-b border-gray-200 dark:border-gray-600 pb-3 last:border-b-0">
                      <!-- Tittle of modules -->
                      <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 capitalize">
                        📁 {{ __('modules.'. $module) }}
                      </h4>
                      
                      <!-- Permissions of modules -->
                      <div class="ml-4 space-y-2">
                        @foreach($modulePermissions as $permission)
                          <div class="flex items-start">
                            <div class="flex items-center h-5">
                              <input 
                                type="checkbox" 
                                value="{{ $permission->id }}" 
                                id="permission-{{ $permission->id }}"
                                wire:model="selectedPermissions"
                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                              >
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="permission-{{ $permission->id }}" class="font-medium text-gray-900 dark:text-white cursor-pointer">
                                {{ $permission->description ?? $permission->name }}
                              </label>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                </div>
                
                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-2">
                  <button
                    type="button"
                    wire:click="closeModal"
                    class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                  >
                    Cancelar
                  </button>
                  <button
                    type="submit"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                  >
                    {{ $roleId ? 'Actualizar' : 'Crear' }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>