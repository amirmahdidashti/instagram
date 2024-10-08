
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

function setTheme(theme) {
    document.body.className = theme;
    localStorage.setItem('theme', theme);
}

function loadTheme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.body.className = savedTheme;
    }
}

window.onload = function() {
    loadTheme();
}
