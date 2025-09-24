@section('meta')
  <x-post-meta-tags :post="$post" />
@endsection
@section('title', $post->title)
<div class="max-w-7xl mx-auto px-4 pt-6 lg:pt-10 grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-10">
  <div>
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-3 leading-tight">
      {{ $post->title }}
    </h1>

    <div class="text-sm text-gray-600 dark:text-gray-400 mb-6">
      <span class="italic">Publicado por</span>
      <span class="text-gray-800 dark:text-white italic">{{ $post->user->name ?? 'Autor desconocido' }}</span>
      <span class="text-gray-500 dark:text-gray-400">· {{ $post->created_at->diffForHumans() }}</span>
    </div>

    @livewire('public.post.post-share-buttons', ['post' => $post])

    @php
      $video = $post->media->firstWhere('file_type', 'video/mp4');
      $images = $post->media->where('file_type', '!=', 'video/mp4');
    @endphp

    @if ($video)
      <div class="relative w-full rounded-md overflow-hidden shadow mb-6">
        <video src="{{ asset($video->url) }}" controls class="w-full h-auto max-h-96 object-contain bg-gray-100 dark:bg-gray-800"></video>
      </div>
    @elseif ($images->isNotEmpty())
      @if ($images->count() > 1)
        {{-- Carrusel para múltiples imágenes --}}
        <div id="custom-controls-gallery" class="relative w-full rounded-md overflow-hidden shadow mb-6" data-carousel="slide">
          <!-- Carousel wrapper -->
          <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            @foreach ($images as $index => $img)
              <div class="hidden duration-700 ease-in-out cursor-pointer" data-carousel-item="{{ $index === 0 ? 'active' : '' }}" onclick="openImageModal('{{ asset($img->url) }}', '{{ $post->title }}')">
                <img src="{{ asset($img->url) }}" 
                  class="w-full h-full object-cover bg-gray-100 dark:bg-gray-800 absolute block top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hover:opacity-90 transition-opacity" 
                  alt="{{ $post->title }}"
                >
                <!-- Icono de zoom -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-20">
                  <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                  </svg>
                </div>
              </div>
            @endforeach
          </div> 
          <!-- Slider controls -->
          <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-white/20 group-hover:bg-white/50 dark:group-hover:bg-white/40 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-white/50 group-focus:outline-none">
              <svg class="w-4 h-4 text-white dark:text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
              </svg>
              <span class="sr-only">Previous</span>
            </span>
          </button>
          <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-white/20 group-hover:bg-white/50 dark:group-hover:bg-white/40 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-white/50 group-focus:outline-none">
              <svg class="w-4 h-4 text-white dark:text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>
              <span class="sr-only">Next</span>
            </span>
          </button>
        </div>
      @else
        {{-- Imagen única sin carrusel --}}
        <div class="relative cursor-pointer group" onclick="openImageModal('{{ asset($images->first()->url) }}', '{{ $post->title }}')">
          <img 
            class="relative w-full rounded-md overflow-hidden shadow mb-6 h-56 md:h-96 object-cover bg-gray-100 dark:bg-gray-800 hover:opacity-90 transition-opacity" 
            src="{{ asset($images->first()->url) }}" 
            alt="{{ $post->title }}"
          >
          <!-- Icono de zoom -->
          <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black bg-opacity-20 rounded-md">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
            </svg>
          </div>
        </div>
      @endif
    @endif
    {{-- FIN: Sección de medios --}}
    <div class="prose prose-lg dark:prose-invert max-w-none text-justify text-gray-500 dark:text-gray-400 animate-fade-in transition-opacity duration-500 ease-out">
      {!! $post->content !!}
    </div>

    @if ($post->tags->isNotEmpty())
      <div class="mt-10">
        <h3 class="text-base font-semibold text-gray-500 dark:text-gray-400 mb-2">Etiquetas relacionadas:</h3>
        <div class="flex flex-wrap gap-2">
          @foreach ($post->tags as $tag)
            <a 
              href="{{ route('public.tags.index', $tag->slug) }}"
              class="inline-block bg-blue-100 text-blue-900 text-xs font-bold px-3 py-1 rounded hover:bg-blue-200 dark:bg-blue-200 dark:text-blue-900 dark:hover:bg-blue-300 transition-colors cursor-pointer"
            >
              #{{ $tag->name }}
            </a>
          @endforeach
        </div>
      </div>
    @endif
    {{-- COMMENT BOX --}}
    @livewire('public.comment.comment-box', ['post' => $post], key('box-'.$post->id))

    {{-- COMMENTS LIST --}}
    @livewire('public.comment.comment-list', ['post' => $post], key('list-'.$post->id))

  </div>

  {{-- SIDEBAR --}}
  <aside class="lg:self-start">
    @php
      $related = \App\Models\Post::whereHas('tags', function($q) use ($post) {
        return $q->whereIn('tags.id', $post->tags->pluck('id'));
      })
      ->where('id', '!=', $post->id)
      ->latest()
      ->take(5)
      ->get();
    @endphp

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
        
      <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white border-b pb-2 border-blue-500">
        Más en {{ $post->tags->first()->name ?? 'esta sección' }}
      </h3>

      <ul class="space-y-3">
        @foreach ($related as $item)
          @php
            $media = $item->media;
            $image = optional($media->where('file_type', '!=', 'video/mp4')->first())->url;
            $video = optional($media->firstWhere('file_type', 'video/mp4'))->url;
          @endphp

          <li class="group">
            <a href="{{ route('public.posts.show', $item->slug) }}" class="flex items-center gap-4 hover:bg-blue-100 dark:hover:bg-blue-900 p-2 rounded transition">
              <div class="w-12 h-12 rounded bg-blue-700 text-white text-sm font-semibold flex items-center justify-center overflow-hidden flex-shrink-0">
                @if ($image)
                  <img src="{{ asset($image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                @elseif ($video)
                  <video src="{{ asset($video) }}" muted preload="metadata" class="w-full h-full object-cover"></video>
                @else
                  {{ Str::limit($item->title, 2, '') }}
                @endif
              </div>
              <span class="text-sm font-medium text-gray-800 dark:text-gray-200 group-hover:underline">
                {{ Str::limit($item->title, 60) }}
              </span>
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </aside>

  <style>
    /* Añade este CSS a tu hoja de estilos */

/* Contenedor responsivo para videos de YouTube */
.prose iframe[src*="youtube.com"],
.prose iframe[src*="youtu.be"] {
    width: 100% !important;
    height: auto !important;
    min-height: 315px; /* Altura mínima razonable */
    aspect-ratio: 16 / 9; /* Mantiene proporción 16:9 */
    border-radius: 8px; /* Opcional: bordes redondeados */
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); /* Opcional: sombra */
}

/* Alternativa: Wrapper responsivo si prefieres más control */
.prose .video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    border-radius: 8px;
    margin: 1rem 0;
}

.prose .video-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
}

/* Para pantallas pequeñas */
@media (max-width: 640px) {
    .prose iframe[src*="youtube.com"],
    .prose iframe[src*="youtu.be"] {
        min-height: 200px;
    }
}
  </style>
</div>