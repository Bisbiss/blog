// Tombol kembali ke atas: muncul setelah halaman di-scroll cukup jauh.
export function initBackToTop() {
    const button = document.querySelector('[data-back-to-top]');
    if (!button) return;

    const toggle = () => button.classList.toggle('is-visible', window.scrollY > 600);
    window.addEventListener('scroll', toggle, { passive: true });
    toggle();

    button.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

// Tombol salin link artikel.
export function initCopyLink() {
    document.querySelectorAll('[data-copy-link]').forEach((button) => {
        button.addEventListener('click', async () => {
            const label = button.querySelector('[data-copy-label]');
            const original = label.textContent;
            try {
                await navigator.clipboard.writeText(button.dataset.copyLink);
                label.textContent = 'Tersalin!';
            } catch {
                window.prompt('Salin link berikut:', button.dataset.copyLink);
            }
            setTimeout(() => (label.textContent = original), 2000);
        });
    });
}
