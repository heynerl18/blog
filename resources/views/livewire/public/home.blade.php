<div class="px-4 md:px-8 xl:px-12">
  <div class="columns-1 md:columns-2 xl:columns-3 gap-7">
    @foreach($posts as $post)
      @if($post->media->isNotEmpty())
        @php
          $video = $post->media->firstWhere('file_type', 'video/mp4');
          $image = $post->media->where('file_type', '!=', 'video/mp4')->first();
        @endphp

        @if($video)
          <div class="group break-inside-avoid mb-8 rounded-lg overflow-hidden shadow-lg bg-gray-900">
            <video class="h-auto max-w-full rounded-t-lg w-full" controls>
              <source src="{{ asset($video->url) }}" type="video/mp4">
              Su navegador no soporta la etiqueta de vídeo.
            </video>

            {{-- Box below visible on hover --}}
            <div class="hidden group-hover:block transition duration-300 ease-in-out bg-black/80 text-white p-4 rounded-b-lg">

              <h5 class="text-white text-lg font-bold mb-1">{{ $post->title }}</h5>
              <div class="text-sm text-gray-300">
                📅 {{ $post->created_at->format('d M, Y') }}
                @if($post->category)
                  | 🏷️ <a href="{{ route('public.categories.index', $post->category->slug) }}" class="text-blue-400 hover:underline">{{ $post->category->name }}</a>
                @endif
              </div>
              <p class="text-sm text-gray-300 mt-2">{{ Str::limit($post->excerpt, 100) }}</p>
            </div>
          </div>

        {{-- 🖼️ Si es imagen --}}
        @elseif($image)
          <div class="relative group break-inside-avoid mb-8 rounded-lg overflow-hidden shadow-lg">
            <img class="h-auto max-w-full rounded-lg" src="{{ asset($image->url) }}" alt="Post Image" />

            {{-- Overlay visible on hover --}}
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 
                        opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out flex flex-col justify-end pointer-events-none">
              <h5 class="text-white text-lg font-bold mb-1">{{ $post->title }}</h5>
              <div class="text-sm text-gray-300">
                📅 {{ $post->created_at->format('d M, Y') }}
                @if($post->category)
                  | 🏷️ <a href="{{ route('public.categories.index', $post->category->slug) }}" class="text-blue-400 hover:underline pointer-events-auto">{{ $post->category->name }}</a>
                @endif
              </div>
              <p class="text-sm text-gray-300 mt-2 pointer-events-auto">{{ Str::limit($post->excerpt, 100) }}</p>
            </div>
          </div>
        @endif
      @endif
    @endforeach
  </div>
</div>
