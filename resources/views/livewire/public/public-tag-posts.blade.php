
<div class="tag-content max-w-5xl mx-auto px-4 mt-0 pt-0">
  <h1 class="text-4xl font-extrabold text-center tracking-tight mb-6 text-gray-900 dark:text-white">
    <span class="text-blue-400 uppercase text-sm block mb-1 flex items-center justify-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M7 7l10 10M7 7a2 2 0 114 0 2 2 0 01-4 0zM17.657 16.657a2 2 0 01-2.828 0l-6.829-6.828a4 4 0 115.657-5.657l6.829 6.828a2 2 0 010 2.828z" />
      </svg>
      Etiqueta
    </span>
    {{ ucfirst($tag->name) }}
  </h1>

  @if($posts->isNotEmpty())
    <ul class="space-y-8">
      @foreach ($posts as $post)
        @php
          $video = $post->media->firstWhere('file_type', 'video/mp4');
          $image = $post->media->where('file_type', '!=', 'video/mp4')->first();
        @endphp
        <li class="rounded-lg shadow-md overflow-hidden bg-white dark:bg-gray-800 transition transform hover:-translate-y-1 hover:shadow-xl animate-fade-in duration-300">
          <div class="relative w-full h-64 rounded-t-lg overflow-hidden">
            @if ($video)
              <video src="{{ asset($video->url) }}" controls class="absolute inset-0 w-full h-full object-cover"></video>
            @elseif ($image)
              <img src="{{ asset($image->url) }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover">
            @elseif ($post->getFirstMediaUrl('featured_image'))
              <img src="{{ $post->getFirstMediaUrl('featured_image', 'medium') }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover">
            @endif

          </div>

          <div class="p-5">

            <h2 class="text-2xl font-bold mb-2">
              <a href="{{ route('public.posts.show', $post->slug) }}"
                class="inline-block text-gray-900 dark:text-white border-b-2 border-transparent hover:border-blue-600 transition">
                {{ $post->title }}
              </a>
            </h2>
              
            <div class="prose dark:prose-invert max-w-none mb-4">
                {!! Str::limit(strip_tags($post->content), 200) !!}
            </div>

            <div class="mt-3 flex flex-wrap gap-2">
              @foreach ($post->tags as $tag)
                <a 
                  href="{{ route('public.tags.index', $tag->slug) }}"
                  class="inline-block bg-blue-100 text-blue-900 text-xs font-bold px-3 py-1 rounded hover:bg-blue-200 dark:bg-blue-100 dark:text-blue-900 dark:hover:bg-blue-200 transition-colors cursor-pointer"
                >
                  #{{ $tag->name }}
                </a>
              @endforeach
            </div>
          </div>
        </li>
      @endforeach
    </ul>
  @else
    <p class="text-gray-600 dark:text-gray-300 text-center mt-10">No hay posts disponibles en esta etiqueta.</p>
  @endif
</div>
