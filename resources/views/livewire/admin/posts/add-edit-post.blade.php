<div>
  <div class="col-span-2">
    <div class="p-3 sm:p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
      <h3 class="mb-4 text-lg sm:text-xl font-semibold dark:text-white">{{ $postId ? 'Editar Nota' : 'Crear Nota' }} </h3>
      <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 sm:gap-6">
          <div class="col-span-1 sm:col-span-6 md:col-span-3">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
            <input type="text" name="title" id="title" wire:model="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingrese el título">
            @error('title')
              <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                <span class="font-medium">{{ $message }}</span>
              </p>
            @enderror
          </div>
            
          <div class="col-span-1 sm:col-span-6 md:col-span-3">
            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorías</label>
            <select wire:model="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option value="">Seleccione una categoría</option>             
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $category_id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            @error('category_id')
              <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                <span class="font-medium">{{ $message }}</span>
              </p>
            @enderror
          </div>
            
          <div class="col-span-1 sm:col-span-6">
            <label for="tags" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Etiquetas</label>
            <div class="flex flex-wrap gap-3 sm:gap-4">
              @foreach ($tags as $tag)
                <div class="flex items-center">
                  <input 
                  id="tag-{{ $tag->id }}"
                  name="tags[]"
                  type="checkbox" 
                  value="{{ $tag->id }}"
                  wire:model="selectedTags"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                >
                  <label for="tag-{{ $tag->id }}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 whitespace-nowrap">
                    {{ $tag->name }}
                  </label>
                </div>
              @endforeach
            </div>
            @error('selectedTags')
              <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                <span class="font-medium">{{ $message }}</span>
              </p>
            @enderror
          </div>
            
          <div 
            x-data="{ postStatus: @entangle('postStatus') }" 
            class="col-span-1 sm:col-span-6"
          >
            <label for="postStatus" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado de la Nota</label>
            <label class="inline-flex items-center mb-5 cursor-pointer">
              <input type="checkbox" wire:model="postStatus" class="sr-only peer">
              <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
              <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="postStatus ? 'Publicado' : 'Borrador'"></span>
            </label>
          </div>
            
          <div class="col-span-1 sm:col-span-6">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenido</label>
            @livewire('admin.posts.rich-text-editor')
            @error('content')
              <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                <span class="font-medium">{{ $message }}</span>
              </p>
            @enderror
          </div>
              
          <div class="col-span-1 sm:col-span-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Tipo de Archivo
            </label>
            <select 
              name="media_type"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
              wire:model.live="selectedMediaType"
            >
              <option value="">Selecciona una opción</option>
              <option value="image">Subir imágenes</option>
              <option value="video">Subir video</option>
            </select>
            @error('selectedMediaType')
              <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                <span class="font-medium">{{ $message }}</span>
              </p>
            @enderror
          </div>
            
          <div x-data="{
            videoPreview: @entangle('videoPreview'),
            mediaType: @entangle('selectedMediaType'),
            imagePreviews: @entangle('imagePreviews'),
            hasExistingImages: @js(!empty($existingImages)),
            hasExistingVideo: @js(!empty($existingVideo)),
              
            validateImages(files) {
              
              if (!files || files.length === 0) {
                if (this.hasExistingImages && this.imagePreviews.length > 0) {
                  return true;
                }
                return false;
              }
              
              if (files.length > 4) {
                return false;
              }
                
              const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
              const maxSize = 2 * 1024 * 1024;
                
              for (let file of files) {
                if (!allowedTypes.includes(file.type)) {
                  return false;
                }
                    
                if (file.size > maxSize) {
                  return false;
                }
              }
                
              return true;
            },
              
            validateVideo(file) {
              if (!file) {
                if (this.hasExistingVideo && this.videoPreview) {
                  return true;
                }
                return false;
              }
                
              const allowedTypes = ['video/mp4'];
              if (!allowedTypes.includes(file.type)) {
                return false;
              }
              
              const maxSize = 10 * 1024 * 1024;
              if (file.size > maxSize) {
                return false;
              }
              
              return true;
            },
              
            previewImages(event) {
              const files = Array.from(event.target.files);
              
              if (files.length === 0) return;
              
              if (this.validateImages(files)) {
                this.imagePreviews = [];
                
                files.forEach(file => {
                  const reader = new FileReader();
                  reader.onload = (e) => {
                    this.imagePreviews.push(e.target.result);
                  };
                  reader.readAsDataURL(file);
                });
                  
                this.hasExistingImages = false;
              } else {
                event.target.value = '';
              }
            },
              
            handleVideoPreview(event) {
              const file = event.target.files[0];
                
              if (!file) return;
                
                if (this.validateVideo(file)) {
                  const reader = new FileReader();
                  reader.onload = (e) => {
                    this.videoPreview = e.target.result;
                  };
                  reader.readAsDataURL(file);
                  
                  this.hasExistingVideo = false;
                } else {
                  event.target.value = '';
                  this.videoPreview = null;
                }
              }
            }"
          class="col-span-1 sm:col-span-6"
          >
              
            {{-- Upload images --}}
            <div x-show="mediaType === 'image'" x-transition>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Subir Imágenes
                <span class="block sm:inline text-xs text-gray-500 dark:text-gray-400 mt-1 sm:mt-0">(Máx. 4 archivos, 2MB c/u, JPG/PNG/WEBP)</span>
              </label>
                
              <input 
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                id="image_input" 
                type="file"
                wire:model="images"
                @change="previewImages($event)"
                accept="image/jpeg,image/jpg,image/png,image/webp"
                multiple
              >
                
              @error('images')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                  <span class="font-medium flex items-start">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="break-words">{{ $message }}</span>
                  </span> 
                </p>
              @enderror

              @error('images.*')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                  <span class="font-medium flex items-start">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="break-words">{{ $message }}</span>
                  </span> 
                </p>
              @enderror
                
              <div x-show="imagePreviews.length > 0" x-transition class="mt-2">
                <p class="text-xs text-green-600 dark:text-green-400 flex items-start">
                  <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span x-text="imagePreviews.length + ' imagen(es) ' + (hasExistingImages ? 'existente(s)' : 'seleccionada(s)')" class="font-medium"></span>
                </p>
              </div>
                
              <div class="mt-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white flex items-center" wire:loading wire:target="images">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando imágenes...
              </div>
                
              <div x-show="imagePreviews.length > 0" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-4">
                <template x-for="(src, index) in imagePreviews" :key="index">
                  <div class="relative group">
                    <img :src="src" 
                      class="w-full h-24 sm:h-32 object-cover rounded-lg shadow-md border-2 border-green-200 dark:border-green-700" 
                      alt="Vista previa"
                    />
                    <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-green-500 text-white rounded-full p-1">
                      <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                  </div>
                </template>
              </div>
            </div>
                
            {{-- Upload video --}}
            <div x-show="mediaType === 'video'" x-transition>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Subir Video
                <span class="block sm:inline text-xs text-gray-500 dark:text-gray-400 mt-1 sm:mt-0">(Máx. 10MB, solo MP4)</span>
              </label>
                
              <input 
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                id="video_input" 
                type="file"
                accept="video/mp4"
                wire:model="video"
                @change="handleVideoPreview($event)"
              >
                
              @error('video')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                  <span class="font-medium flex items-start">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="break-words">{{ $message }}</span>
                  </span>
                </p>
              @enderror
                
              <div x-show="videoPreview" x-transition class="mt-2">
                <p class="text-xs text-green-600 dark:text-green-400 flex items-start">
                  <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span x-text="hasExistingVideo ? 'Video existente cargado' : 'Video seleccionado correctamente'" class="font-medium"></span>
                </p>
              </div>
                
              <div class="mt-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white flex items-center" wire:loading wire:target="video">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando video...
              </div>
            
              <div x-show="videoPreview" x-transition class="mt-4">
                <video 
                  x-bind:src="videoPreview"
                  controls 
                  class="w-full max-w-full sm:max-w-md h-auto aspect-video rounded-lg shadow-md border-2 border-green-200 dark:border-green-700"
                >
                  Tu navegador no soporta la reproducción de videos.
                </video>
              </div>
            </div>
          </div>
          <div class="col-span-1 sm:col-span-6 flex flex-col sm:flex-row gap-2 sm:gap-0">
            <button 
              class="w-full sm:w-auto text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed"
              type="submit"
              wire:loading.attr="disabled"
              wire:target="save,images,video"
            >
              <span wire:loading.remove wire:target="save">{{ $postId ? 'Actualizar' : 'Guardar' }} Nota</span>
              <span wire:loading wire:target="save" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Guardando...
              </span>
            </button> 
            <a href="{{ route('admin.posts.index') }}" class="w-full sm:w-auto text-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 sm:ml-2">Volver</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>