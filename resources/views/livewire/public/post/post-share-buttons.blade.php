<div>
  <div class="flex gap-3 sm:gap-3 mb-6 flex-wrap">
    {{-- Facebook --}}
    <a href="{{ $this->facebookUrl }}"
      target="_blank"
      rel="noopener noreferrer"
      onclick="return openShareWindow(this.href, 'facebook')"
      class="flex items-center justify-center sm:justify-start gap-0 sm:gap-1 px-3 py-2 sm:px-4 sm:py-2 text-xs sm:text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 shadow-sm w-11 h-11 sm:w-auto sm:h-auto sm:min-w-0 flex-shrink-0">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M22 12a10 10 0 1 0-11.7 9.85v-6.98h-2.6v-2.87h2.6v-2.2c0-2.56 1.52-3.98 3.86-3.98 1.12 0 2.3.2 2.3.2v2.54h-1.3c-1.28 0-1.68.8-1.68 1.6v1.84h2.84l-.45 2.87h-2.39v6.98A10 10 0 0 0 22 12"/>
      </svg>
      <span class="hidden sm:inline">Facebook</span>
    </a>

    {{-- Twitter --}}
    <a href="{{ $this->twitterUrl }}"
      target="_blank"
      rel="noopener noreferrer"
      onclick="return openShareWindow(this.href, 'twitter')"
      class="flex items-center justify-center sm:justify-start gap-0 sm:gap-1 px-3 py-2 sm:px-4 sm:py-2 text-xs sm:text-sm font-medium border border-gray-800 rounded-lg text-gray-800 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-800 transition w-11 h-11 sm:w-auto sm:h-auto sm:min-w-0 flex-shrink-0">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
      </svg>
      <span class="hidden sm:inline">Twitter</span>
    </a>

    {{-- WhatsApp --}}
    <a href="{{ $this->whatsappUrl }}"
      target="_blank"
      rel="noopener noreferrer"
      class="flex items-center justify-center sm:justify-start gap-0 sm:gap-1 px-3 py-2 sm:px-4 sm:py-2 text-xs sm:text-sm font-medium border border-green-500 rounded-lg text-green-700 hover:bg-green-50 dark:text-green-400 dark:border-green-400 dark:hover:bg-green-900/20 transition w-11 h-11 sm:w-auto sm:h-auto sm:min-w-0 flex-shrink-0">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12.017 2.25A9.77 9.77 0 0 0 2.25 12.017c0 1.742.459 3.375 1.262 4.784L2.25 21.75l4.983-1.26a9.717 9.717 0 0 0 4.784 1.26c5.395 0 9.767-4.372 9.767-9.767A9.77 9.77 0 0 0 12.017 2.25zm4.842 14.017c-.193.543-1.143 1.05-1.575 1.09-.432.04-.988.177-3.343-.714-2.539-1.002-4.189-3.611-4.318-3.78-.13-.168-1.052-1.397-1.052-2.667 0-1.27.665-1.896.902-2.156.237-.26.515-.325.686-.325.172 0 .343.002.495.009.158.007.369-.06.578.441.214.515.73 1.778.795 1.908.065.13.108.282.022.455-.087.173-.13.282-.26.433-.13.151-.272.337-.39.454-.13.129-.265.268-.114.526.151.26.674 1.112 1.446 1.798.994.883 1.832 1.156 2.092 1.286.26.13.411.108.563-.065.151-.173.65-.759.823-1.019.173-.26.346-.216.584-.129.238.087 1.508.711 1.767.841.26.13.433.195.498.303.065.108.065.625-.128 1.168z"/>
      </svg>
      <span class="hidden sm:inline">WhatsApp</span>
    </a>
      
    {{-- Botón de Copiar URL con tooltip --}}
    <div class="relative" x-data="{ copied: false, showTooltip: false }">
      <button
        class="flex items-center justify-center sm:justify-start gap-0 sm:gap-1 px-3 py-2 sm:px-4 sm:py-2 text-xs sm:text-sm font-medium border border-gray-400 dark:border-gray-600 rounded-lg text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition w-11 h-11 sm:w-auto sm:h-auto sm:min-w-0 flex-shrink-0"
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        @click="
          navigator.clipboard.writeText('{{ $currentUrl }}').then(() => {
            copied = true;
            showTooltip = true;
            setTimeout(() => {
              copied = false;
              showTooltip = false;
            }, 2000);
          });
        "
      >
        <span x-show="!copied">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
          </svg>
        </span>
        <span x-show="copied" class="text-green-500">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
          </svg>
        </span>
        <span class="hidden sm:inline">
          <span x-show="!copied">Copiar URL</span>
        </span>
      </button>
      
      {{-- Tooltip --}}
      <div 
        x-show="showTooltip" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip dark:bg-gray-700 bottom-full left-1/2 transform -translate-x-1/2 mb-2 whitespace-nowrap"
        style="display: none;"
      >
        <span x-text="copied ? '¡Copiado!' : 'Copiar al portapapeles'"></span>
      </div>
    </div>
  </div>

  {{-- Estilos del componente --}}
  @once
    <style>
      /* ESTILOS GENERALES */
      .transition {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      }

      /* ESTADOS DE FOCUS PARA ACCESIBILIDAD */
      button:focus, a:focus {
        outline: 2px solid rgb(59 130 246);
        outline-offset: 2px;
      }

      /* PREVENIR OVERFLOW EN TEXTOS */
      .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      /* MEJORAS DE RENDIMIENTO */
      .share-button {
        will-change: transform;
      }

      /* ESTILOS PARA ADAPTAR EL BOTÓN AL DISEÑO */
      .w-11.h-11 .label {
        display: none !important;
      }

      @media (min-width: 640px) {
        .w-11.h-11 {
          width: auto !important;
          height: auto !important;
          min-width: 0 !important;
          min-height: 0 !important;
        }
      }
    </style>
  @endonce

  {{-- JavaScript del componente --}}
  @once
    <script>
    // Función para ventanas de compartir genéricas
    function openShareWindow(url, platform) {
      const windowSpecs = {
        facebook: 'width=626,height=436',
        twitter: 'width=600,height=400',
        default: 'width=600,height=400'
      };
        
      const specs = windowSpecs[platform] || windowSpecs.default;
      window.open(url, platform + '-share', specs + ',toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1');
      
      // Analytics opcional
      if (typeof gtag !== 'undefined') {
        gtag('event', 'share', {
          method: platform.charAt(0).toUpperCase() + platform.slice(1),
          content_id: window.location.pathname
        });
      }
        
      return false;
    }
    </script>
  @endonce
</div>