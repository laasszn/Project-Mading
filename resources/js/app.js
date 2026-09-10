// js global, fungsi inline dilempar ke window biar kepanggil

document.addEventListener('contextmenu', e => e.preventDefault());
document.onkeydown = function(e) {
    if (e.keyCode === 123) return false;
    if (e.ctrlKey && e.shiftKey && ['I','C','J'].includes(e.key.toUpperCase())) return false;
    if (e.ctrlKey && e.key.toLowerCase() === 'u') return false;
};

document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 50);

    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || link.target === '_blank' || href.startsWith('javascript')) return;
            e.preventDefault();
            document.body.classList.remove('loaded');
            document.body.classList.add('fade-out');
            setTimeout(() => {
                window.location.href = href;
            }, 300);
        });
    });
});

function toggleMenu() {
    const el = document.getElementById('navLinks');
    if (el) el.classList.toggle('active');
}
window.toggleMenu = toggleMenu;

// ganti tema gelap-terang
function syncThemeIcon() {
    const icon = document.getElementById('themeToggleIcon');
    if (!icon) return;
    const light = document.documentElement.dataset.theme === 'light';
    icon.className = light ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
}

function setTheme(mode) {
    const theme = mode === 'light' ? 'light' : 'dark';
    document.documentElement.dataset.theme = theme;
    try {
        localStorage.setItem('smezine-theme', theme);
    } catch (e) { /* biarin kalau gagal */ }
    syncThemeIcon();
}

function toggleTheme() {
    setTheme(document.documentElement.dataset.theme === 'light' ? 'dark' : 'light');
}
window.toggleTheme = toggleTheme;

document.addEventListener('DOMContentLoaded', syncThemeIcon);

// slider hero
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll('.hero .slide');
    const dots = document.querySelectorAll('.hero .dot');
    const hero = document.querySelector('.hero');
    if (!slides.length || !hero) return;

    let currentSlide = 0;
    let intervalId = null;

    function showSlide(index) {
        const total = slides.length;
        if (total === 0) return;
        const next = (index + total) % total;
        if (next === currentSlide) return;

        slides[currentSlide]?.classList.remove('active');
        dots[currentSlide]?.classList.remove('active');

        currentSlide = next;

        slides[currentSlide]?.classList.add('active');
        dots[currentSlide]?.classList.add('active');
    }

    function startAuto() {
        stopAuto();
        if (slides.length <= 1) return;
        intervalId = setInterval(() => showSlide(currentSlide + 1), 4000);
    }
    function stopAuto() {
        if (intervalId) { clearInterval(intervalId); intervalId = null; }
    }

    // mulai dari slide 0
    slides.forEach((s, i) => s.classList.toggle('active', i === 0));
    dots.forEach((d, i) => {
        d.classList.toggle('active', i === 0);
        d.style.cursor = 'pointer';
        d.addEventListener('click', () => {
            showSlide(i);
            startAuto();
        });
    });

    // jeda pas hover
    hero.addEventListener('mouseenter', stopAuto);
    hero.addEventListener('mouseleave', startAuto);

    startAuto();
});

// navbar ngumpet pas scroll ke bawah, nongol lagi pas scroll ke atas
(function () {
    const HIDE_AFTER = 120; // jangan ngumpet kalau masih di atas
    let lastY = window.scrollY || 0;
    let ticking = false;

    function update() {
        ticking = false;
        const nav = document.querySelector('.navbar');
        if (!nav) return;
        const y = window.scrollY || 0;
        // jangan ngumpet pas menu hp kebuka
        const menuOpen = document.getElementById('navLinks')?.classList.contains('active');
        if (menuOpen || y <= HIDE_AFTER) {
            nav.classList.remove('navbar-hidden');
        } else if (y > lastY) {
            nav.classList.add('navbar-hidden');
        } else if (y < lastY) {
            nav.classList.remove('navbar-hidden');
        }
        lastY = y;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });
})();
