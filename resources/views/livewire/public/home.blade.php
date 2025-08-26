{{-- Estilos CSS integrados - SOLO BOTÓN ESTILO UNSPLASH --}}
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Botón estilo Unsplash - minimalista y elegante */
    .unsplash-button {
        background: rgba(255, 255, 255, 0.9);
        color: #111827;
        border: 1px solid rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        font-weight: 500;
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 13px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-shadow: none;
    }

    .unsplash-button:hover {
        background: rgba(255, 255, 255, 1);
        color: #000;
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Sombra sutil para el título en imágenes - estilo Unsplash */
    .image-text-shadow {
        text-shadow: 0 2px 8px rgba(0,0,0,0.6), 0 1px 3px rgba(0,0,0,0.4);
    }
</style>

{{-- JavaScript simple --}}
<script>
    function playVideo(videoElement) {
        // Pausar todos los otros videos
        document.querySelectorAll('video').forEach(v => {
            if (v !== videoElement && !v.paused) {
                v.pause();
                v.muted = true;
            }
        });
        
        // Reproducir este video
        if (videoElement.paused) {
            // Activar sonido y reproducir
            videoElement.muted = false;
            videoElement.play().catch(() => {
                // Si falla con sonido, intentar sin sonido
                videoElement.muted = true;
                videoElement.play();
            });
        } else {
            videoElement.pause();
        }
    }
</script>

{{-- Grid principal --}}
<div class="px-4 md:px-8 xl:px-12">
    <div class="columns-1 md:columns-2 xl:columns-3 gap-7">
        @foreach($posts as $post)
            {{-- 🎥 Si es un video --}}
            @if($post->media->isNotEmpty())
                @php
                    $video = $post->media->firstWhere('file_type', 'video/mp4');
                    $image = $post->media->where('file_type', '!=', 'video/mp4')->first();
                @endphp

                @if($video)
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transform transition-all duration-300 hover:scale-[1.02]">
                        {{-- Video limpio con onclick para reproducir --}}
                        <div class="relative">
                            <video class="w-full h-auto object-cover cursor-pointer" 
                                   muted 
                                   preload="metadata"
                                   style="max-height: 400px;"
                                   onclick="playVideo(this)">
                                <source src="{{ asset($video->url) }}" type="video/mp4">
                                Su navegador no sopporta la etiqueta de vídeo.
                            </video>
                        </div>
                        
                        {{-- Sección de información debajo --}}
                        <div class="p-4">
                            <h5 class="text-gray-900 dark:text-white text-lg font-bold mb-3 line-clamp-2">
                                {{ $post->title }}
                            </h5>
                            
                            {{-- Metadatos: fecha y categoría --}}
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 flex-wrap mb-4">
                                <span class="flex items-center gap-1">
                                    📅 {{ $post->created_at->format('d M, Y') }}
                                </span>
                                @if($post->category)
                                    <span class="flex items-center gap-1">
                                        🏷️ <span class="text-blue-600 dark:text-blue-400">{{ $post->category->name }}</span>
                                    </span>
                                @endif
                            </div>

                            {{-- Botón Flowbite separado --}}
                            <div class="flex justify-start">
                                <a href="{{ route('public.posts.show', $post->slug) }}">
                                    <button type="button" class="text-blue-600 dark:text-blue-400 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                                        Leer más
                                        <svg class="w-3 h-3 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                {{-- 🖼️ Si es una imagen - BOTÓN ESTILO UNSPLASH --}}
                @elseif($image)
                    <div class="group relative break-inside-avoid mb-8 overflow-hidden cursor-pointer transform transition-all duration-300 hover:scale-[1.02]">
                        <a href="{{ route('public.posts.show', $post->slug) }}" class="block">
                            <img class="h-auto max-w-full w-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                 src="{{ asset($image->url) }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy" />
                            
                            {{-- Título centrado y botón abajo a la derecha estilo Unsplash --}}
                            <div class="absolute inset-0 flex flex-col justify-between p-4">
                                {{-- Título centrado con sombra estilo Unsplash --}}
                                <div class="flex-1 flex items-center justify-center">
                                    <h5 class="text-white text-xl font-bold line-clamp-2 image-text-shadow text-center">{{ $post->title }}</h5>
                                </div>
                                
                                {{-- Botón estilo Unsplash abajo a la derecha --}}
                                <div class="flex justify-end">
                                    <button type="button" class="unsplash-button inline-flex items-center">
                                        Leer más
                                        <svg class="w-3 h-3 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

            {{-- 📝 Posts sin imagen - Card estilo mejorado --}}
            @else
                <div class="group break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 cursor-pointer transform transition-all duration-300 hover:scale-[1.02] hover:border-gray-300 dark:hover:border-gray-600">
                    <a href="{{ route('public.posts.show', $post->slug) }}" class="block p-6 h-full">
                        {{-- Ícono de documento --}}
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        
                        {{-- Título principal --}}
                        <h5 class="text-gray-900 dark:text-white text-lg font-bold mb-4 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                            {{ $post->title }}
                        </h5>
                        
                        {{-- Metadatos --}}
                        <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-3 mb-4">
                            <span class="flex items-center gap-1">
                                📅 {{ $post->created_at->format('d M, Y') }}
                            </span>
                            @if($post->category)
                                <span class="flex items-center gap-1">
                                    🏷️ <span class="text-blue-600 dark:text-blue-400 hover:underline">{{ $post->category->name }}</span>
                                </span>
                            @endif
                        </div>

                        {{-- Extracto del post (opcional) --}}
                        @if($post->excerpt)
                            <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3 leading-relaxed mb-4">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                        @endif

                        {{-- Botón Flowbite separado --}}
                        <div class="flex justify-start">
                            <button type="button" class="text-blue-600 dark:text-blue-400 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                                Leer más
                                <svg class="w-3 h-3 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>