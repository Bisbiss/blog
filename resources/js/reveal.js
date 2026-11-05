// Animasi halus saat elemen [data-reveal] masuk layar.
// Elemen yang sudah terlihat saat halaman dibuka tidak disembunyikan, jadi tidak ada kedipan.
export function initReveal() {
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('reveal-pending');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -10% 0px' });

    document.querySelectorAll('[data-reveal]').forEach((el) => {
        if (el.getBoundingClientRect().top < window.innerHeight) return;
        el.classList.add('reveal-pending');
        observer.observe(el);
    });
}
