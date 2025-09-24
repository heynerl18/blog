class ImageModal {
  constructor() {
    this.modal = null;
    this.modalImage = null;
    this.modalTitle = null;
    this.init();
  }

  init() {
    // Crear el modal dinámicamente si no existe
    this.createModal();
    this.bindEvents();
  }

  createModal() {
    // Verificar si ya existe
    if (document.getElementById('imageModal')) {
      this.setElements();
      return;
    }

    // Crear el modal
    const modalHTML = `
      <div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4">
        <div class="relative w-full h-full flex items-center justify-center">
          <button id="closeModalBtn" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold z-10 bg-black bg-opacity-50 rounded-full p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          
          <div class="relative max-w-4xl max-h-[85vh] w-full h-full flex items-center justify-center">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            <div id="modalTitle" class="absolute -bottom-12 left-0 right-0 bg-black bg-opacity-70 text-white p-3 text-center rounded-lg mx-4"></div>
          </div>
        </div>
      </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    this.setElements();
  }

  setElements() {
    this.modal = document.getElementById('imageModal');
    this.modalImage = document.getElementById('modalImage');
    this.modalTitle = document.getElementById('modalTitle');
  }

  bindEvents() {
    // Cerrar con botón
    document.addEventListener('click', (e) => {
      if (e.target.id === 'closeModalBtn' || e.target.closest('#closeModalBtn')) {
        this.close();
      }
    });

    // Cerrar con clic en fondo
    document.addEventListener('click', (e) => {
      if (e.target.id === 'imageModal') {
        this.close();
      }
    });

    // Cerrar con ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.close();
      }
    });

    // Prevenir clic en controles de carrusel
    document.addEventListener('click', (e) => {
      if (e.target.closest('[data-carousel-prev], [data-carousel-next]')) {
        e.stopPropagation();
      }
    });

    // Prevenir clic en imagen del modal
    document.addEventListener('click', (e) => {
      if (e.target.id === 'modalImage') {
        e.stopPropagation();
      }
    });
  }

  open(imageSrc, imageTitle) {
    if (!this.modal) return;

    this.modalImage.src = imageSrc;
    this.modalImage.alt = imageTitle;
    this.modalTitle.textContent = imageTitle;

    this.modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }

  close() {
    if (!this.modal) return;

    this.modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  window.imageModal = new ImageModal();
});

// Función global para compatibilidad
window.openImageModal = (imageSrc, imageTitle) => {
  if (window.imageModal) {
    window.imageModal.open(imageSrc, imageTitle);
  }
};

window.closeImageModal = () => {
  if (window.imageModal) {
    window.imageModal.close();
  }
};