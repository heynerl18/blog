(function() {
  const savedTheme = localStorage.getItem('color-theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  
  if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
})();

// Función para inicializar el tema
function initializeTheme() {
  const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
  const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
  const themeToggleBtn = document.getElementById('theme-toggle');

  // Verificar que los elementos existen antes de usarlos
  if (!themeToggleDarkIcon || !themeToggleLightIcon || !themeToggleBtn) {
    console.warn('Theme toggle elements not found in DOM');
    return;
  }

  function applySavedTheme() {
    const savedTheme = localStorage.getItem('color-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
      document.documentElement.classList.add('dark');
      themeToggleLightIcon.classList.remove('hidden');
      themeToggleDarkIcon.classList.add('hidden');
    } else {
      document.documentElement.classList.remove('dark');
      themeToggleDarkIcon.classList.remove('hidden');
      themeToggleLightIcon.classList.add('hidden');
    }
  }

  // Aplicar tema guardado
  applySavedTheme();

  // Remover listeners existentes para evitar duplicados
  const newThemeToggleBtn = themeToggleBtn.cloneNode(true);
  themeToggleBtn.parentNode.replaceChild(newThemeToggleBtn, themeToggleBtn);

  // Agregar nuevo event listener
  newThemeToggleBtn.addEventListener('click', function () {
    const newDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const newLightIcon = document.getElementById('theme-toggle-light-icon');
    
    // Toggle icon visibility
    newDarkIcon.classList.toggle('hidden');
    newLightIcon.classList.toggle('hidden');

    // Toggle theme and save to localStorage
    if (document.documentElement.classList.contains('dark')) {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('color-theme', 'light');
    } else {
      document.documentElement.classList.add('dark');
      localStorage.setItem('color-theme', 'dark');
    }
  });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeTheme);

// Reinicializar después de cada navegación de Livewire
document.addEventListener('livewire:navigated', initializeTheme);

// También escuchar el evento de Livewire cuando se actualiza el contenido
document.addEventListener('livewire:load', initializeTheme);