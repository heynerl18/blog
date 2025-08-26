<div>
  <div class="col-span-2">
    <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
      <h3 class="mb-4 text-xl font-semibold dark:text-white">{{ $postId ? 'Editar Nota' : 'Crear Nota' }} </h3>
      <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                <input type="text" name="title" id="title" wire:model="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ingrese el título">
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('title') <span class="font-medium">{{ $message }}</span> @enderror</p>
            </div>
            
            <div class="col-span-6 sm:col-span-3">
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorías</label>
                <select wire:model="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option selected>Seleccione una categoría</option>             
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $category->id == $category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                  @endforeach
                </select>
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('category_id') <span class="font-medium">{{ $message }}</span> @enderror</p>   
            </div>
            
            <div class="col-span-6">
                <label for="tags" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Etiquetas</label>
                <div class="flex flex-wrap">
                  @foreach ($tags as $tag)
                  <div class="flex items-center me-4">
                    <input 
                    id="tag-{{ $tag->id }}"
                    name="tags[]"
                    type="checkbox" 
                    value="{{ $tag->id }}"
                    wire:model="selectedTags"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    >
                    <label for="tag-{{ $tag->id }}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                      {{ $tag->name }}
                    </label>
                  </div>
                  @endforeach
                </div>
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('selectedTags') <span class="font-medium">{{ $message }}</span> @enderror</p>   
            </div>
            
            <div 
              x-data="{ postStatus: @entangle('postStatus') }" 
              class="col-span-6"
            >
              <label for="postStatus" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado de la Nota</label>
              <label class="inline-flex items-center mb-5 cursor-pointer">
                <input type="checkbox" wire:model="postStatus" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="postStatus ? 'Publicado' : 'Borrador'"></span>
              </label>
            </div>
            
            <div class="col-span-6">
                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenido</label>
                @livewire('admin.posts.rich-text-editor')
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('content') <span class="font-medium">{{ $message }}</span> @enderror</p>   
            </div>
              
            <div class="col-span-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Tipo de Archivo
                </label>
                <select 
                    name="media_type"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    wire:model.live="selectedMediaType"
                    @change="clearErrors()"
                >
                    <option value="" selected>Selecciona una opción</option>
                    <option value="image">Subir imágenes</option>
                    <option value="video">Subir video</option>
                </select>
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('selectedMediaType') <span class="font-medium">{{ $message }}</span> @enderror</p>   
            </div>
            
            <!-- Sección de archivos actualizada -->
            <div x-data="{
                videoPreview: @entangle('videoPreview'),
                mediaType: @entangle('selectedMediaType'),
                imagePreviews: @entangle('imagePreviews'),
                errors: {
                    images: '',
                    video: ''
                },
                
                validateImages(files) {
                    this.errors.images = '';
                    
                    if (!files || files.length === 0) {
                        this.errors.images = 'Por favor selecciona al menos una imagen.';
                        return false;
                    }
                    
                    if (files.length > 4) {
                        this.errors.images = 'Puedes subir un máximo de 4 imágenes.';
                        return false;
                    }
                    
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    
                    for (let file of files) {
                        if (!allowedTypes.includes(file.type)) {
                            this.errors.images = 'Solo se permiten archivos JPG, JPEG y PNG.';
                            return false;
                        }
                        
                        if (file.size > maxSize) {
                            this.errors.images = 'Cada imagen debe ser menor a 2MB.';
                            return false;
                        }
                    }
                    
                    return true;
                },
                
                validateVideo(file) {
                    this.errors.video = '';
                    
                    if (!file) {
                        this.errors.video = 'Por favor selecciona un archivo de video.';
                        return false;
                    }
                    
                    if (file.type !== 'video/mp4') {
                        this.errors.video = 'El archivo debe ser un video en formato MP4.';
                        return false;
                    }
                    
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    if (file.size > maxSize) {
                        this.errors.video = 'El video no debe superar los 10 MB.';
                        return false;
                    }
                    
                    return true;
                },
                
                previewImages(event) {
                    const files = Array.from(event.target.files);
                    
                    if (this.validateImages(files)) {
                        this.imagePreviews = [];
                        
                        files.forEach(file => {
                            this.imagePreviews.push(URL.createObjectURL(file));
                        });
                    } else {
                        event.target.value = '';
                        this.imagePreviews = [];
                    }
                },
                
                handleVideoPreview(event) {
                    const file = event.target.files[0];
                    
                    if (this.validateVideo(file)) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.videoPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        event.target.value = '';
                        this.videoPreview = null;
                    }
                },
                
                clearErrors() {
                    this.errors = { images: '', video: '' };
                }
            }"
            class="col-span-6"
            @submit-form="if (!validateBeforeSubmit()) $event.preventDefault()">
                
                {{-- Upload images --}}
                <div x-show="mediaType === 'image'" x-transition>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Subir Imágenes
                        <span class="text-xs text-gray-500 dark:text-gray-400">(Máximo 4 archivos, 2MB c/u, JPG/PNG)</span>
                    </label>
                    
                    <input 
                        class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                        :class="errors.images ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        id="image_input" 
                        type="file"
                        wire:model="images"
                        @change="previewImages($event)"
                        accept="image/jpeg,image/jpg,image/png"
                        multiple
                    >
                    
                    <!-- Error del cliente -->
                    <div x-show="errors.images" x-transition class="mt-2">
                        <p class="text-xs text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span x-text="errors.images" class="font-medium"></span>
                        </p>
                    </div>
                    
                    <!-- Error del servidor -->
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                        @error('images') 
                            <span class="font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span> 
                        @enderror
                    </p>
                    
                    <!-- Success feedback -->
                    <div x-show="!errors.images && imagePreviews.length > 0" x-transition class="mt-2">
                        <p class="text-xs text-green-600 dark:text-green-400 flex items-center">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span x-text="imagePreviews.length + ' imagen(es) seleccionada(s) correctamente'" class="font-medium"></span>
                        </p>
                    </div>
                    
                    <!-- Indicador de carga -->
                    <div class="mt-2 text-sm font-medium text-gray-900 dark:text-white flex items-center" wire:loading wire:target="images">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Subiendo imágenes...
                    </div>
                    
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="(src, index) in imagePreviews" :key="index">
                            <div class="relative">
                                <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md" 
                                     :class="!errors.images ? 'border-2 border-green-200' : ''" />
                                <div x-show="!errors.images" class="absolute top-2 right-2 bg-green-500 text-white rounded-full p-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
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
                        <span class="text-xs text-gray-500 dark:text-gray-400">(Máximo 10MB, solo MP4)</span>
                    </label>
                    
                    <input 
                        class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                        :class="errors.video ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        id="video_input" 
                        type="file"
                        accept="video/mp4"
                        wire:model="video"
                        @change="handleVideoPreview($event)"
                    >
                    
                    <!-- Error del cliente -->
                    <div x-show="errors.video" x-transition class="mt-2">
                        <p class="text-xs text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span x-text="errors.video" class="font-medium"></span>
                        </p>
                    </div>
                    
                    <!-- Error del servidor -->
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                        @error('video') 
                            <span class="font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span> 
                        @enderror
                    </p>
                    
                    <!-- Success feedback -->
                    <div x-show="!errors.video && videoPreview" x-transition class="mt-2">
                        <p class="text-xs text-green-600 dark:text-green-400 flex items-center">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Video seleccionado correctamente</span>
                        </p>
                    </div>
                    
                    <!-- Indicador de carga -->
                    <div class="mt-2 text-sm font-medium text-gray-900 dark:text-white flex items-center" wire:loading wire:target="video">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Subiendo video...
                    </div>
                
                    <div x-show="videoPreview" class="mt-4">
                        @if ($videoPreview)
                            <video 
                                controls 
                                class="w-full max-w-md h-64 rounded-lg shadow-md"
                                :class="!errors.video ? 'border-2 border-green-200' : ''"
                                src="{{ $videoPreview }}"
                            >
                                Tu navegador no soporta la reproducción de videos.
                            </video>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-span-6 sm:col-full">
                <button 
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed"
                    type="submit"
                    wire:loading.attr="disabled"
                    x-on:click="
                        if (mediaType === 'image') {
                            const fileInput = document.getElementById('image_input');
                            if ((!fileInput.files || fileInput.files.length === 0) && (!imagePreviews || imagePreviews.length === 0)) {
                                errors.images = 'Por favor selecciona al menos una imagen.';
                                $event.preventDefault();
                                return false;
                            }
                        } else if (mediaType === 'video') {
                            const fileInput = document.getElementById('video_input');
                            if ((!fileInput.files || fileInput.files.length === 0) && !videoPreview) {
                                errors.video = 'Por favor selecciona un archivo de video.';
                                $event.preventDefault();
                                return false;
                            }
                        }
                    "
                >
                    <span wire:loading.remove>{{ $postId ? 'Actualizar' : 'Guardar' }} Nota</span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardando...
                    </span>
                </button> 
                <a href="{{ route('admin.posts.index') }}" class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-2">Volver</a>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>