@section('title', 'Etiqueta: ' . $tag->name)
<div class="tag-content w-full max-w-7xl mx-auto px-4 lg:px-6 xl:px-8 mt-0 pt-0">
  <h1 class="text-4xl font-extrabold text-center tracking-tight mb-12 text-gray-900 dark:text-white">
    <span class="text-blue-600 dark:text-blue-400 uppercase text-sm block mb-2 flex items-center justify-center gap-2 font-semibold">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
        d="M7 7l10 10M7 7a2 2 0 114 0 2 2 0 01-4 0zM17.657 16.657a2 2 0 01-2.828 0l-6.829-6.828a4 4 0 115.657-5.657l6.829 6.828a2 2 0 010 2.828z" />
      </svg>
      Etiqueta
    </span>
    {{ ucfirst($tag->name) }}
  </h1>

  @if($posts->isNotEmpty())
    {{-- GRID UNIFORME DE CARDS --}}
    <div class="grid-container">
      @foreach ($posts as $post)
        @php
          $video = $post->media->firstWhere('file_type', 'video/mp4');
          $image = $post->media->where('file_type', '!=', 'video/mp4')->first();
        @endphp
        
        <div class="card-uniform">
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 h-full flex flex-col">
            
            {{-- Imagen/Video Principal - Altura fija --}}
            @if ($video || $image)
              <div class="relative overflow-hidden h-48 bg-gray-100 dark:bg-gray-700">
                @if ($video)
                  <video 
                    src="{{ asset($video->url) }}" 
                    class="w-full h-full object-cover"
                    poster="{{ $image ? asset($image->url) : '' }}"
                    muted
                    preload="metadata"
                  ></video>
                  {{-- Play button overlay --}}
                  <div class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 hover:opacity-100 transition-opacity">
                    <div class="bg-white/95 rounded-full p-3 shadow-lg">
                      <svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                  </div>
                @elseif ($image)
                  <img 
                    src="{{ asset($image->url) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                  >
                @endif
              </div>
            @else
              {{-- Card sin imagen - Con icono --}}
              <div class="h-48 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center">
                <div class="text-center">
                  <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                      <path fill-rule="evenodd" d="M14 2v6h6l-6-6z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Artículo</span>
                </div>
              </div>
            @endif

            {{-- Contenido del Card - Altura flexible --}}
            <div class="p-5 flex-1 flex flex-col">
              {{-- Título --}}
              <h3 class="font-bold text-gray-900 dark:text-white mb-2 leading-tight text-lg line-clamp-2">
                <a href="{{ route('public.posts.show', $post->slug) }}" 
                   class="block hover:text-blue-600 hover:underline dark:hover:text-blue-400 transition-colors">
                  {{ $post->title }}
                </a>
              </h3>
              
              {{-- Descripción --}}
              @if(strlen(strip_tags($post->content)) > 0)
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4 line-clamp-2 flex-grow">
                  {{ Str::limit(strip_tags($post->content), 120) }}
                </p>
              @endif

              {{-- Tags con estilo Flowbite --}}
              @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-1.5 mb-4">
                  @foreach ($post->tags->take(2) as $postTag)
                    <a href="{{ route('public.tags.index', $postTag->slug) }}"
                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 transition-colors">
                      #{{ $postTag->name }}
                    </a>
                  @endforeach
                  @if($post->tags->count() > 2)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 cursor-default" 
                          title="Ver todas las etiquetas en el artículo completo">
                      <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0C4.612 0 0 4.612 0 10s4.612 10 10 10 10-4.612 10-10S15.388 0 10 0Zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8Z"/>
                        <path d="M9 5h2v2H9V5Zm0 4h2v6H9V9Z"/>
                      </svg>
                      +{{ $post->tags->count() - 2 }} más
                    </span>
                  @endif
                </div>
              @endif

              {{-- Footer con comentarios y fecha --}}
              <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
                {{-- Contador de comentarios --}}
                <div class="flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 10.5h.01m-4.01 0h.01M8 10.5h.01M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.6a1 1 0 0 0-.69.275l-2.866 2.723A.5.5 0 0 1 8 18.635V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                  </svg>
                  <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $post->comments->count() ?? 0 }}
                  </span>
                </div>
                
                {{-- Fecha de publicación --}}
                <div class="flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                  </svg>
                  <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $post->created_at ? $post->created_at->diffForHumans() : 'Hace poco' }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  @else
    {{-- Estado vacío --}}
    <div class="text-center py-20">
      <div class="max-w-md mx-auto">
        <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/20 dark:to-blue-800/20 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">No hay contenido disponible</h3>
        <p class="text-gray-500 dark:text-gray-400">
          Aún no hay posts con esta etiqueta.
        </p>
      </div>
    </div>
  @endif

  {{-- CSS PARA GRID UNIFORME --}}
  <style>
    /* Grid Container Responsivo con centrado para pocos items */
    .grid-container {
      display: grid;
      grid-gap: 16px;
      width: 100%;
      margin: 0 auto;
      justify-items: center;
      /* Mobile first: siempre 1 columna */
      grid-template-columns: 1fr;
    }

    /* Centrado específico para pocos cards - solo en desktop */
    @media (min-width: 768px) {
      .grid-container:has(.card-uniform:nth-child(1):nth-last-child(1)) {
        /* 1 card: centrado */
        max-width: 400px;
        grid-template-columns: 1fr;
      }

      .grid-container:has(.card-uniform:nth-child(2):nth-last-child(1)) {
        /* 2 cards: centrados */
        max-width: 840px;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 24px;
      }

      .grid-container:has(.card-uniform:nth-child(3):nth-last-child(1)) {
        /* 3 cards: centrados */
        max-width: 1260px;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 24px;
      }
    }

    /* Cards Uniformes */
    .card-uniform {
      width: 100%;
      height: auto;
      min-height: 380px;
    }

    /* Responsive Grid Columns con fallback */
    @media (min-width: 640px) {
      .grid-container {
        grid-gap: 20px;
      }
      .grid-container:not(:has(.card-uniform:nth-child(1):nth-last-child(1))):not(:has(.card-uniform:nth-child(2):nth-last-child(1))):not(:has(.card-uniform:nth-child(3):nth-last-child(1))) {
        grid-template-columns: repeat(2, 1fr);
        max-width: none;
      }
    }

    @media (min-width: 768px) {
      .grid-container {
        grid-gap: 24px;
      }
      .grid-container:not(:has(.card-uniform:nth-child(1):nth-last-child(1))):not(:has(.card-uniform:nth-child(2):nth-last-child(1))):not(:has(.card-uniform:nth-child(3):nth-last-child(1))) {
        grid-template-columns: repeat(2, 1fr);
        max-width: none;
      }
    }

    @media (min-width: 1024px) {
      .grid-container:not(:has(.card-uniform:nth-child(1):nth-last-child(1))):not(:has(.card-uniform:nth-child(2):nth-last-child(1))):not(:has(.card-uniform:nth-child(3):nth-last-child(1))) {
        grid-template-columns: repeat(3, 1fr);
        max-width: none;
      }
    }

    @media (min-width: 1280px) {
      .grid-container {
        grid-gap: 28px;
      }
      .grid-container:not(:has(.card-uniform:nth-child(1):nth-last-child(1))):not(:has(.card-uniform:nth-child(2):nth-last-child(1))):not(:has(.card-uniform:nth-child(3):nth-last-child(1))) {
        grid-template-columns: repeat(3, 1fr);
        max-width: none;
      }
    }

    @media (min-width: 1536px) {
      .grid-container {
        grid-gap: 32px;
      }
      .grid-container:not(:has(.card-uniform:nth-child(1):nth-last-child(1))):not(:has(.card-uniform:nth-child(2):nth-last-child(1))):not(:has(.card-uniform:nth-child(3):nth-last-child(1))) {
        grid-template-columns: repeat(4, 1fr);
        max-width: none;
      }
    }

    /* Line clamp utilities */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Card hover effects - Removido hover global */
    .card-uniform {
      transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .card-uniform img {
      transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Tags hover individuales */
    .card-uniform a[href*="tags"]:hover {
      transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
      .grid-container {
        grid-gap: 16px;
      }
      
      .card-uniform {
        min-height: 340px;
      }
      
      .card-uniform .p-5 {
        padding: 1rem;
      }
    }

    /* Ensure consistent card heights in each row */
    @media (min-width: 1024px) {
      .grid-container {
        align-items: stretch;
      }
    }
  </style>
</div>