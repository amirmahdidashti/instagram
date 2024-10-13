
function openpopup(id) {
    document.getElementById(id).style.display = 'flex';
}

function closepopup(id) {
    document.getElementById(id).style.display = 'none';
}
function toggleDisplay(id) {
    const element = document.getElementById(id);
    if (element.style.display == 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'none';
    }
}
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

window.onload = function () {
    loadTheme();
}
