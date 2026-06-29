document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (!darkModeToggle) return;
    let cssLink = document.createElement('link');

    // Inicializar el estado del modo oscuro (opcional: verificar localStorage o preferencia del sistema)
    let isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';           
    
    if(isDarkMode) {
        updateBodyClass(isDarkMode);
        toggleDarkModeCSS(isDarkMode);
        updateButtonEmoji(isDarkMode); 
    }

    darkModeToggle.addEventListener('click', () => {
        isDarkMode = !isDarkMode;        
        localStorage.setItem('darkModeEnabled', isDarkMode ? 'true' : 'false');
        updateBodyClass(isDarkMode);
        toggleDarkModeCSS(isDarkMode);
        updateButtonEmoji(isDarkMode);
    });
});

function updateBodyClass(isEnabled) {
    document.body.classList.toggle('dark-mode', isEnabled);
}

function toggleDarkModeCSS(isEnabled) {
    let cssLink = document.getElementById('darkModeStylesheet');

    if (isEnabled && !cssLink) {
        console.log(isEnabled);
        // Cargar el CSS si está activado y no existe
        cssLink = document.createElement('link');
        cssLink.id = 'darkModeStylesheet';
        cssLink.rel = 'stylesheet';
        cssLink.href = '/css/dark_mode.css'; // Ruta al nuevo archivo CSS
        document.head.appendChild(cssLink);
    } else if (!isEnabled && cssLink) {
        // Remover el CSS si está desactivado
        cssLink.remove();
    }
}

function updateButtonEmoji(isEnabled) {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.textContent = isEnabled ? '☀️' : '🌙';
    }
}
