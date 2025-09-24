
@vite(['resources/css/home.css', 'resources/js/home.js'])

@section('title', 'Inicio')

<div>
    {{-- Loading State --}}
    <div id="loading-container" class="loading-container">
        <div class="w-full mx-auto px-4 md:px-8 xl:px-12" style="max-width: min(100%, 1800px);">
            <div class="flex flex-col items-center justify-center min-h-[50vh] space-y-8">
                {{-- Loading indicator principal --}}
                <button type="button" class="bg-blue-600 text-white font-medium rounded-lg text-sm px-4 py-2 inline-flex items-center opacity-75 cursor-not-allowed" disabled>
                    <svg class="mr-3 w-5 h-5 animate-spin text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m15.84 7.16a7.5 7.5 0 1 1-7.68 0"></path>
                    </svg>
                    Iniciando…
                </button>
                
                {{-- Skeleton cards para simular el contenido --}}
                <div class="w-full columns-1 md:columns-2 xl:columns-3 2xl:columns-4 gap-7">
                    {{-- Skeleton card 1 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-48 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-3/4 rounded"></div>
                            <div class="skeleton-card h-3 w-1/2 rounded"></div>
                            <div class="skeleton-card h-8 w-20 rounded"></div>
                        </div>
                    </div>
                    
                    {{-- Skeleton card 2 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-32 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-2/3 rounded"></div>
                            <div class="skeleton-card h-3 w-1/3 rounded"></div>
                            <div class="skeleton-card h-8 w-16 rounded"></div>
                        </div>
                    </div>
                    
                    {{-- Skeleton card 3 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-40 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-4/5 rounded"></div>
                            <div class="skeleton-card h-3 w-1/2 rounded"></div>
                            <div class="skeleton-card h-8 w-24 rounded"></div>
                        </div>
                    </div>

                    {{-- Skeleton card 4 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-56 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-5/6 rounded"></div>
                            <div class="skeleton-card h-3 w-2/3 rounded"></div>
                            <div class="skeleton-card h-8 w-18 rounded"></div>
                        </div>
                    </div>

                    {{-- Skeleton card 5 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-36 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-3/5 rounded"></div>
                            <div class="skeleton-card h-3 w-2/5 rounded"></div>
                            <div class="skeleton-card h-8 w-22 rounded"></div>
                        </div>
                    </div>

                    {{-- Skeleton card 6 --}}
                    <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="skeleton-card h-44 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="skeleton-card h-4 w-4/6 rounded"></div>
                            <div class="skeleton-card h-3 w-1/4 rounded"></div>
                            <div class="skeleton-card h-8 w-20 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido Principal (inicialmente oculto) --}}
    <div id="content-container" class="content-container">
        <div class="w-full mx-auto px-4 md:px-8 xl:px-12" style="max-width: min(100%, 1800px);">
            <div class="columns-1 md:columns-2 xl:columns-3 2xl:columns-4 gap-7">
                @foreach($posts as $post)
                    {{-- 🎥 Si es un video --}}
                    @if($post->media->isNotEmpty())
                        @php
                            $video = $post->media->firstWhere('file_type', 'video/mp4');
                            $image = $post->media->where('file_type', '!=', 'video/mp4')->first();
                        @endphp

                        @if($video)
                            <div class="break-inside-avoid mb-8 overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-sm">
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
                                    <h5 class="text-gray-900 dark:text-white text-lg font-bold mb-3 line-clamp-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
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
                                            <button type="button" class="text-blue-600 dark:text-blue-400 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center transition-all duration-200 hover:shadow-sm hover:-translate-y-0.5">
                                                Leer más
                                                <svg class="w-3 h-3 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        {{-- 🖼️ Si es una imagen - CON EFECTOS MEJORADOS --}}
                        @elseif($image)
                            <div class="group relative break-inside-avoid mb-8 overflow-hidden cursor-pointer transform transition-all duration-300 hover:scale-[1.01] image-hover-effect">
                                <a href="{{ route('public.posts.show', $post->slug) }}" class="block">
                                    <img class="h-auto max-w-full w-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                         src="{{ asset($image->url) }}" 
                                         alt="{{ $post->title }}" 
                                         loading="lazy" />
                                    
                                    {{-- Overlay con gradiente mejorado --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                                    
                                    {{-- Título centrado y botón abajo a la derecha estilo Unsplash --}}
                                    <div class="absolute inset-0 flex flex-col justify-between p-4 z-10">
                                        {{-- Título centrado con sombra estilo Unsplash --}}
                                        <div class="flex-1 flex items-center justify-center">
                                            <h5 class="text-white text-xl font-bold line-clamp-2 image-text-shadow text-center transform group-hover:scale-105 transition-transform duration-300">{{ $post->title }}</h5>
                                        </div>
                                        
                                        {{-- Botón estilo Unsplash abajo a la derecha --}}
                                        <div class="flex justify-end">
                                            <button type="button" class="unsplash-button inline-flex items-center">
                                                Leer más
                                                <svg class="w-3 h-3 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                    {{-- 📝 Posts sin imagen - Card con gradiente dinámico --}}
                    @else
                        <div class="group break-inside-avoid mb-8 overflow-hidden text-card-gradient cursor-pointer transform transition-all duration-300 hover:scale-[1.01] text-card-hover">
                            <a href="{{ route('public.posts.show', $post->slug) }}" class="block p-6 h-full text-white relative z-10">
                                {{-- Ícono de documento con animación --}}
                                <div class="flex items-center justify-center w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg mb-4 icon-bounce">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                
                                {{-- Título principal --}}
                                <h5 class="text-white text-lg font-bold mb-4 line-clamp-2 group-hover:text-white/90 transition-colors duration-300">
                                    {{ $post->title }}
                                </h5>
                                
                                {{-- Metadatos con iconos mejorados --}}
                                <div class="text-sm text-white/80 flex items-center gap-3 mb-4">
                                    <span class="flex items-center gap-1 bg-white/10 rounded-full px-2 py-1">
                                        📅 {{ $post->created_at->format('d M, Y') }}
                                    </span>
                                    @if($post->category)
                                        <span class="flex items-center gap-1 bg-white/10 rounded-full px-2 py-1">
                                            🏷️ {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Extracto del post (opcional) --}}
                                @if($post->excerpt)
                                    <p class="text-sm text-white/90 line-clamp-3 leading-relaxed mb-4">
                                        {{ Str::limit($post->excerpt, 120) }}
                                    </p>
                                @endif

                                {{-- Botón con estilo consistente --}}
                                <div class="flex justify-start">
                                    <button type="button" class="bg-white/20 backdrop-blur-sm text-white border border-white/30 hover:bg-white/30 focus:outline-none focus:ring-4 focus:ring-white/20 font-medium rounded-lg text-sm px-3 py-1.5 inline-flex items-center transition-all duration-200 hover:shadow-sm hover:-translate-y-0.5">
                                        Leer más
                                        <svg class="w-3 h-3 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </div>
</div>