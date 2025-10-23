
function initializeSidebar() {
  const sidebar = document.getElementById('sidebar');

  if (sidebar) {
    const toggleSidebarMobile = (sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose) => {
      sidebar.classList.toggle('hidden');
      sidebarBackdrop.classList.toggle('hidden');
      toggleSidebarMobileHamburger.classList.toggle('hidden');
      toggleSidebarMobileClose.classList.toggle('hidden');
    }

    const toggleSidebarMobileEl = document.getElementById('toggleSidebarMobile');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');

    if (toggleSidebarMobileEl && !toggleSidebarMobileEl.dataset.initialized) {
      toggleSidebarMobileEl.addEventListener('click', () => {
        toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
      });
      toggleSidebarMobileEl.dataset.initialized = 'true';
    }

    if (sidebarBackdrop && !sidebarBackdrop.dataset.initialized) {
      sidebarBackdrop.addEventListener('click', () => {
        toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
      });
      sidebarBackdrop.dataset.initialized = 'true';
    }
  }

  const crudToggleButton = document.querySelector('[data-collapse-toggle="dropdown-crud"]');
  const crudDropdown = document.getElementById('dropdown-crud');

  if (crudToggleButton && crudDropdown && !crudToggleButton.dataset.initialized) {
    crudToggleButton.addEventListener('click', () => {
      crudDropdown.classList.toggle('hidden');
      
      const arrowIcon = crudToggleButton.querySelector('svg[sidebar-toggle-item]:last-child');
      if (arrowIcon) {
        arrowIcon.classList.toggle('rotate-180');
      }
    });
    crudToggleButton.dataset.initialized = 'true';
  }
}

document.addEventListener('DOMContentLoaded', initializeSidebar);

document.addEventListener('livewire:navigated', initializeSidebar);