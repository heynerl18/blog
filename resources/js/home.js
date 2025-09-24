let isLoading = true;
let postsLoaded = false;

// SOLUCIÓN: Hacer la función global
window.playVideo = function(videoElement) {
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
};

// Función para asignar gradientes aleatorios a cards de texto
function assignRandomGradients() {
    const textCards = document.querySelectorAll('.text-card-gradient');
    const gradients = ['gradient-card-1', 'gradient-card-2', 'gradient-card-3', 'gradient-card-4', 'gradient-card-5', 'gradient-card-6'];
    
    textCards.forEach((card, index) => {
        const gradientClass = gradients[index % gradients.length];
        card.classList.add(gradientClass);
    });
}

// Función para mostrar el contenido principal
function showContent() {
    const loadingContainer = document.getElementById('loading-container');
    const contentContainer = document.getElementById('content-container');
    
    if (loadingContainer && contentContainer) {
        // Fade out loading
        loadingContainer.classList.add('fade-out');
        
        setTimeout(() => {
            loadingContainer.style.display = 'none';
            contentContainer.classList.add('fade-in');
            isLoading = false;
        }, 500);
    }
}

// Simular carga de posts
function simulatePostsLoading() {
    // Simular tiempo de carga (puedes ajustar esto o conectarlo con datos reales)
    setTimeout(() => {
        postsLoaded = true;
        assignRandomGradients();
        showContent();
    }, 2000); // 2 segundos de loading simulado
}

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    simulatePostsLoading();
});