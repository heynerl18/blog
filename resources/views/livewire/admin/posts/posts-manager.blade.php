<div>
  <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
      <div class="mb-4">
        <nav class="flex mb-5" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
            <li class="inline-flex items-center">
              <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                Inicio
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Notas</a>
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Lista</span>
              </div>
            </li>
          </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Todas las notas</h1>
      </div>
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center w-full sm:w-auto sm:divide-x sm:divide-gray-100 dark:divide-gray-700">
          <div class="lg:pr-3 w-full lg:w-auto">
            <label for="posts-search" class="sr-only">Buscar</label>
            <div class="relative lg:w-64 xl:w-96">
              <input 
                type="text"
                id="posts-search"
                name="search"
                wire:model.live.debounce.500ms="search"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Buscar nota">
            </div>
          </div>
        </div>
        <!-- Button Section -->
        @can('posts.create')
          <div class="flex items-center justify-end">
            <a
              href="{{ route('admin.posts.create') }}"
              class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 w-full sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Agregar nota
            </a>
          </div>
        @endcan
      </div>
    </div>
  </div>
  <div class="flex flex-col">
    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
          @if (session('alert'))
            <div id="alert-message" data-message="{{ session('alert') }}"></div>
          @endif
          <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
              <tr>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  ID
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Título
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Contenido
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Autor
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Categoría
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Estado
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Etiquetas
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Recursos
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                  Acciones
                </th>
              </tr>
            </thead>
              <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                  
                @foreach ($posts as $post)
                  <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                      <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $post->id }}</div>
                      </div>
                    </td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $post->title }}</td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $post->content }}</td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $post->user->name }}</td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $post->category->name }}</td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">{{ $post->status === 1 ? 'Publicado' : 'Borrador' }}</td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                      @if($post->tags->count() > 0)
                        @foreach($post->tags as $tag)
                          <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $tag->name }}</span>
                        @endforeach
                      @else
                        <span class="text-gray-400 dark:text-gray-500 text-xs">Sin etiquetas</span>
                      @endif
                    </td>
                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                      @if($post->media->count() > 0)
                        <div class="flex gap-1 items-center">
                          @php
                            $imageCount = $post->media->where(function ($file){
                              return Str::startsWith($file->file_type, 'image');
                            })->count();

                            $videoCount = $post->media->where(function ($file){
                              return Str::startsWith($file->file_type, 'video');
                            })->count();
                          @endphp
                            
                          @if($imageCount > 0)
                            <div class="relative w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600 flex items-center justify-center group" title="{{ $imageCount }} imagen(es)">
                              <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                              </svg>
                              @if($imageCount > 1)
                                <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">{{ $imageCount }}</span>
                              @endif
                            </div>
                          @endif
                            
                          @if($videoCount > 0)
                            <div class="relative w-12 h-12 bg-gray-800 dark:bg-gray-700 rounded border border-gray-600 flex items-center justify-center group" title="Video">
                              <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                              </svg>
                            </div>
                          @endif
                        </div>
                      @else
                        <span class="text-gray-400 dark:text-gray-500 text-xs">Sin recursos</span>
                      @endif
                    </td>

                    <td class="p-4 space-x-2 whitespace-nowrap">
                      @can('posts.edit')
                        <a
                          href="{{ route('admin.posts.edit', $post->id) }}"
                          class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            Editar
                        </a>
                      @endcan
                      @can('posts.destroy')
                        <button 
                          type="button" 
                          x-on:click="$dispatch('openModalDelete', { postId: {{ $post->id }} })"
                          class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            Eliminar
                        </button>
                      @endcan
                      @can('posts.share')
                        <button
                          type="button"
                          onclick="shareFacebook('{{ route('public.posts.show', $post->slug) }}')"
                          class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900"
                        >
                          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                          </svg>
                          Compartir
                        </button>
                      @endcan
                      @cannot('posts.edit')
                        @cannot('posts.destroy')
                          @cannot('posts.share')
                            <span class="text-sm text-gray-400 dark:text-gray-500">Sin permisos</span>
                          @endcannot
                        @endcannot
                      @endcannot
                    </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{-- Pagination --}}
  <livewire:pagination
    :totalItems="$posts->total()"
    :itemsPerPage="$posts->perPage()"
    :currentPage="$posts->currentPage()"
  />
  {{-- Open Modal Delete --}}
  @livewire('admin.posts.delete-post')
  
</div>

<script>

  function shareFacebook(url) {
    const encodedUrl = encodeURIComponent(url);
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
    if (isMobile) {
      const mobileShareUrl = `https://m.facebook.com/sharer.php?u=${encodedUrl}`;
      window.location.href = mobileShareUrl;
    } else {
      const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
      const width = 626;
      const height = 436;
      const left = (screen.width / 2) - (width / 2);
      const top = (screen.height / 2) - (height / 2);
      
      window.open(
        shareUrl,
        'facebook-share',
        `width=${width},height=${height},top=${top},left=${left},toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1`
      );
    }
    
    return false;
  }

  function showAlert(data) {

    if (typeof data === 'string') {
      data = { message: data, type: 'success' };
    }
    
    if (Array.isArray(data)) {
      data = data[0];
    }
    
    const type = data.type || 'success';
    const title = type === 'error' ? '¡Error!' : type === 'warning' ? '¡Advertencia!' : '¡Éxito!';
    
    Swal.fire({
      icon: type,
      title: title,
      text: data.message,
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end',
      timerProgressBar: true,
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const alertMessage = document.getElementById('alert-message');
    if (alertMessage) {
      const message = alertMessage.getAttribute('data-message');
      showAlert({ message: message, type: 'success' });
    }
  });
</script>
  
@script
  <script>
    Livewire.on('showAlert', (data) => {
      showAlert(data);
    });
  </script>
@endscript