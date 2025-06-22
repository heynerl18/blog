<div class="max-w-7xl mx-auto px-4 pt-6 lg:pt-10 grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-10">

  {{-- CONTENIDO PRINCIPAL --}}
  <div>
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-3 leading-tight">
      {{ $post->title }}
    </h1>

    <div class="text-sm text-gray-600 dark:text-gray-400 mb-6">
      <span class="italic">Publicado por</span>
      <span class="text-gray-800 dark:text-white italic">{{ $post->user->name ?? 'Autor desconocido' }}</span>
      <span class="text-gray-500 dark:text-gray-400">· {{ $post->created_at->diffForHumans() }}</span>
    </div>

    <div class="flex gap-2 mb-6">

      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
        target="_blank"
        class="flex items-center gap-2 px-4 py-1 text-sm font-medium border border-gray-400 dark:border-gray-600 rounded text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.7 9.85v-6.98h-2.6v-2.87h2.6v-2.2c0-2.56 1.52-3.98 3.86-3.98 1.12 0 2.3.2 2.3.2v2.54h-1.3c-1.28 0-1.68.8-1.68 1.6v1.84h2.84l-.45 2.87h-2.39v6.98A10 10 0 0 0 22 12"/></svg>
        Compartir
      </a>
      <button onclick="copyUrl(this)" class="flex items-center gap-2 px-4 py-1 text-sm font-medium border border-gray-400 dark:border-gray-600 rounded text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
        <span class="icon-wrapper"></span>
        <span class="label">Copiar URL</span>
      </button>
    </div>

    @php
      $video = $post->media->firstWhere('file_type', 'video/mp4');
      $images = $post->media->where('file_type', '!=', 'video/mp4');
    @endphp

    <div class="relative w-full rounded-md overflow-hidden shadow mb-6 h-[400px]">
      @if ($video)
        <video src="{{ asset($video->url) }}" controls class="absolute inset-0 w-full h-full object-cover"></video>
      @elseif ($images->isNotEmpty())
        <div id="indicators-carousel" class="relative w-full h-full rounded-md overflow-hidden" data-carousel="static">
          <div class="relative w-full h-full overflow-hidden rounded-lg">
            @foreach ($images as $index => $img)
              <div class="absolute w-full h-full {{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                <img 
                  src="{{ asset($img->url) }}" 
                  alt="{{ $post->title }}" 
                  class="block w-full h-full object-cover"
                >
              </div>
            @endforeach
          </div>
          <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
            @foreach ($images as $index => $img)
              <button type="button" class="w-3 h-3 rounded-full " aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}" {{ $index === 0 ? 'aria-current=true' : '' }}></button>
            @endforeach
          </div>

          <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70">
              <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
              </svg>
            </span>
          </button>
          <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70">
              <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>
            </span>
          </button>
        </div>
      @endif
    </div>

    <div class="prose dark:prose-invert max-w-none text-justify">
      {!! $post->content !!}
    </div>

    @if ($post->tags->isNotEmpty())
      <div class="mt-10">
        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-300 mb-2">Etiquetas relacionadas:</h3>
        <div class="flex flex-wrap gap-2">
          @foreach ($post->tags as $tag)
            <a 
              href="{{ route('tags.index', $tag->slug) }}"
              class="inline-block bg-blue-300 text-blue-900 text-xs font-bold px-3 py-1 rounded hover:bg-blue-400 dark:bg-blue-300 dark:text-blue-900 dark:hover:bg-blue-400 transition-colors cursor-pointer"
            >
              #{{ $tag->name }}
            </a>
          @endforeach
        </div>
      </div>
    @endif

    {{-- COMMENT BOX --}}
    @livewire('public.comment-box', ['post' => $post], key('box-'.$post->id))

    {{-- COMMENTS LIST --}}
    @livewire('public.comment-list', ['post' => $post], key('list-'.$post->id))

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
            <a href="{{ route('posts.show', $item->slug) }}" class="flex items-center gap-4 hover:bg-blue-100 dark:hover:bg-blue-900 p-2 rounded transition">

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

</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.icon-wrapper').forEach(el => {
      el.innerHTML = `
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
        </svg>
      `;
    });
  });

  function copyUrl(button) {
    const url = '{{ request()->url() }}';
    navigator.clipboard.writeText(url).then(() => {
      const iconWrapper = button.querySelector('.icon-wrapper');
      const label = button.querySelector('.label');

      iconWrapper.innerHTML = `
        <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 11.917 9.724 16.5 19 7.5"/>
        </svg>
      `;

      label.textContent = 'URL copiado!';
      label.classList.add('font-bold', 'text-green-500');

      setTimeout(() => {
        iconWrapper.innerHTML = `
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
          </svg>
        `;
        label.textContent = 'Copiar URL';
        label.classList.remove('font-bold', 'text-green-500');
      }, 2500);
    });
  }
</script>

