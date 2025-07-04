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
              <div class="col-span-6">
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado de la Nota</label>
                <label class="inline-flex items-center mb-5 cursor-pointer">
                  <input type="checkbox" wire:click="togglePostStatus" class="sr-only peer" @if($postStatus == 'Publicado') checked @endif>
                  <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $postStatus ? 'Publicado' : 'Borrador' }}</span>
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
              {{-- id="media_type" --}} 
              name="media_type"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
              wire:model="selectedMediaType"
              {{-- x-on:change="mediaType = $event.target.value" --}}
              >
                <option value="" selected>Selecciona una opción</option>
                <option value="image">Subir imágenes</option>
                <option value="video">Subir video</option>
              </select>
              <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('selectedMediaType') <span class="font-medium">{{ $message }}</span> @enderror</p>   
            </div>
            
            <div x-data="{
              videoPreview: @entangle('videoPreview'),
              handleVideoPreview(event) {
                const file = event.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = (e) => {
                    this.videoPreview = e.target.result;
                  };
                  reader.readAsDataURL(file);
                } else {
                  this.videoPreview = null;
                }
              }
            }"
            class="col-span-6" 
            >
              {{-- Upload images --}}
              <div  x-data="{
                  mediaType: @entangle('selectedMediaType'),
                  imagePreviews: @entangle('imagePreviews'),
                  previewImages(event) {
                    this.imagePreviews = []
                    const files = event.target.files
                    if (files.length > 0){
                      for (let i = 0; i < files.length; i++) {
                        this.imagePreviews.push(URL.createObjectURL(files[i]))
                      }
                    }
                  }
                }"
                x-show="mediaType === 'image'"
              >
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Subir Imágenes</label>
                <input 
                  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                  id="image_input" 
                  type="file"
                  wire:model="images"
                  @change="previewImages($event)"
                  accept="image/*"
                  multiple
                >
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('images') <span class="font-medium">{{ $message }}</span> @enderror</p>   
                {{-- <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" wire:loading wire:target="images">Subiendo...</div> --}}
                <div class="mt-4 grid grid-cols-3 gap-4">
                  <template x-for="src in imagePreviews" :key="src">
                    <img :src="src" class="w-full h-40 object-cover rounded-lg shadow-xl dark:shadow-gray-800" />
                  </template>
                </div>
              </div>
              
              {{-- Upload video --}}
              <div x-data="{ mediaType: @entangle('selectedMediaType') }" x-show="mediaType === 'video'" {{-- x-show="$wire.selectedMediaType === 'video'" --}}>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="video_input">Subir Video</label>
                <input 
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                id="video_input" 
                type="file"
                accept="video/mp4"
                wire:model="video"
                @change="handleVideoPreview($event)"
                >
                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">@error('video') <span class="font-medium">{{ $message }}</span> @enderror</p>   
                {{-- <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" wire:loading wire:target="video">Subiendo...</div> --}}
              
                <div x-show="videoPreview" class="mt-4">
                  @if ($videoPreview)
                    <video 
                      controls 
                      class="w-full h-80 rounded-lg shadow-xl dark:shadow-gray-800"
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
                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                type="submit"
              >
                {{ $postId ? 'Actualizar' : 'Guardar' }} Nota
              </button> 
              <a href="{{ route('admin.posts.index') }}" class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Volver</a>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
