// Sidebar: force visible and disable toggle behavior
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');

    if (sidebar) {
        sidebar.classList.remove('hidden');
    }

    if (mainWrapper) {
        mainWrapper.classList.add('sidebar-open');
    }

    // No-op toggle to avoid errors from leftover onclick handlers
    window.toggleSidebar = function () { };

    // Ensure sidebar remains visible on resize
    window.addEventListener('resize', function () {
        if (sidebar) sidebar.classList.remove('hidden');
        if (mainWrapper) mainWrapper.classList.add('sidebar-open');
    });
});
