<div>
  <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
      <div class="mb-4">
        <nav class="flex mb-5" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
            <li class="inline-flex items-center">
              <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white" wire:navigate>
                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Inicio
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-gray-700 md:ml-2 dark:text-gray-300">Comentarios</span>
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Lista</span>
              </div>
            </li>
          </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Todos los comentarios</h1>
      </div>
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Search Section -->
        <div class="flex items-center w-full sm:w-auto sm:divide-x sm:divide-gray-100 dark:divide-gray-700">
          <div class="lg:pr-3 w-full lg:w-auto">
            <label for="comments-search" class="sr-only">Buscar</label>
            <div class="relative lg:w-64 xl:w-96">
              <input type="text" name="search" wire:model.live.debounce.500ms="search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Buscar comentario, usuario o post">
            </div>
          </div>
        </div>
        <!-- Filters -->
        {{-- <div class="flex items-center gap-3">
          <!-- Status Filter -->
          <div class="flex items-center space-x-2">
            <label for="statusFilter" class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Estado:</label>
            <select wire:model.live="statusFilter" id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="all">Todos</option>
              <option value="approved">Aprobados</option>
              <option value="pending">Pendientes</option>
              <option value="rejected">Rechazados</option>
            </select>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
  <div class="flex flex-col">
    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
          <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
              <tr>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">ID</th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Comentario</th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Usuario</th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Post</th>
                <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Tipo</th>
                <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Estado</th>
                <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Likes</th>
                <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Fecha</th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Acciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
              @forelse ($comments as $comment)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                  <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $comment->id }}
                  </td>
                  <td class="p-4 text-sm text-gray-900 dark:text-white max-w-xs">
                    <div class="truncate" title="{{ $comment->comment }}">
                      {{ Str::limit($comment->comment, 80) }}
                    </div>
                  </td>
                  <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                    <div class="flex items-center">
                      <div class="h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center mr-2">
                        <span class="text-sm font-medium text-primary-600 dark:text-primary-300">
                          {{ substr($comment->user->name, 0, 1) }}
                        </span>
                      </div>
                      <span>{{ $comment->user->name }}</span>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                    <div class="truncate" title="{{ $comment->post->title }}">
                      {{ Str::limit($comment->post->title, 50) }}
                    </div>
                  </td>
                  <td class="p-4 text-center">
                    @if($comment->parent_id)
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        Respuesta
                      </span>
                    @else
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                        Principal
                      </span>
                    @endif
                  </td>
                  <td class="p-4 text-center">
                    @switch($comment->status)
                      @case('approved')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                          </svg>
                          Aprobado
                        </span>
                        @break
                      @case('pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                          </svg>
                          Pendiente
                        </span>
                        @break
                      @case('rejected')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                          </svg>
                          Rechazado
                        </span>
                      @break
                    @endswitch
                  </td>
                  <td class="p-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                      <span class="inline-flex items-center text-sm text-blue-600 dark:text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                        </svg>
                        {{ $comment->likes_count }}
                      </span>
                      <span class="inline-flex items-center text-sm text-red-600 dark:text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                        </svg>
                        {{ $comment->dislikes_count }}
                      </span>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400 text-center">
                    {{ $comment->created_at->format('d/m/Y') }}
                  </td>
                  <td class="p-4 space-x-2 whitespace-nowrap">
                    @can('comments.view')
                      <a href="{{ route('public.posts.show', $comment->post->slug) }}#comment-{{ $comment->id }}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                        Ver
                      </a>
                    @endcan

                    @can('comments.moderate')
                      @if($comment->status !== 'approved')
                        <button type="button" x-on:click="$dispatch('openModalModerate', { commentId: {{ $comment->id }}, action: 'approve' })" class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300" title="Aprobar">
                          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                          </svg>
                        </button>
                      @endif
                      
                      @if($comment->status !== 'rejected')
                        <button type="button" x-on:click="$dispatch('openModalModerate', { commentId: {{ $comment->id }}, action: 'reject' })" class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-center text-white bg-orange-600 rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300" title="Rechazar">
                          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                          </svg>
                        </button>
                      @endif
                    @endcan
                  
                    @can('comments.destroy')
                      <button type="button" x-on:click="$dispatch('openModalDelete', { commentId: {{ $comment->id }} })" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Eliminar
                      </button>
                    @endcan
                    
                    @cannot('comments.view')
                      @cannot('comments.destroy')
                        <span class="text-sm text-gray-400 dark:text-gray-500">Sin permisos</span>
                      @endcannot
                    @endcannot
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center justify-center py-8">
                      <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                      </svg>
                      <p class="text-lg font-medium">No se encontraron comentarios.</p>
                      <p class="text-sm text-gray-400 mt-1">Intenta ajustar los filtros de búsqueda.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  {{-- Pagination --}}
  <livewire:pagination 
    :key="$comments->currentPage() . '-' . $comments->total()" 
    :totalItems="$comments->total()" 
    :itemsPerPage="$comments->perPage()" 
    :currentPage="$comments->currentPage()" 
  />

  {{-- Modals --}}
  @livewire('admin.comments.delete-comment')
  @livewire('admin.comments.moderate-comment')

</div>


@script
<script>
  Livewire.on('showAlert', (data) => {
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
  });
</script>
@endscript