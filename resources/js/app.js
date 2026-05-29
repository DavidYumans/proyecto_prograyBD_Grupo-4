import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Scroll-reveal: add .visible when element enters viewport
document.addEventListener('DOMContentLoaded', () => {
    const targets = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (!targets.length) return;

    const revealEl = (el) => {
        el.classList.add('visible');
        io.unobserve(el);
    };

    const io = new IntersectionObserver(
        (entries) => entries.forEach(e => e.isIntersecting && revealEl(e.target)),
        { threshold: 0.05, rootMargin: '0px 0px 80px 0px' }
    );

    targets.forEach(el => io.observe(el));

    // Immediately reveal everything currently in (or near) the viewport
    requestAnimationFrame(() => {
        targets.forEach(el => {
            if (el.getBoundingClientRect().top < window.innerHeight + 120) revealEl(el);
        });
    });
});
