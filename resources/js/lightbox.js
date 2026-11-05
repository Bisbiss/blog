// Lightbox untuk link <a data-lightbox="grup" data-caption="...">. Tanpa JS, link tetap membuka gambar biasa.
export function initLightbox() {
    const dialog = document.getElementById('lightbox');
    if (!dialog || typeof dialog.showModal !== 'function') return;

    const image = dialog.querySelector('[data-lightbox-image]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    const counter = dialog.querySelector('[data-lightbox-counter]');
    const prevBtn = dialog.querySelector('[data-lightbox-prev]');
    const nextBtn = dialog.querySelector('[data-lightbox-next]');
    let items = [];
    let index = 0;

    const show = (i) => {
        index = (i + items.length) % items.length;
        const link = items[index];
        image.src = link.href;
        image.alt = link.dataset.caption || '';
        caption.textContent = link.dataset.caption || '';
        counter.textContent = items.length > 1 ? `${index + 1} / ${items.length}` : '';
        [prevBtn, nextBtn].forEach((btn) => btn.classList.toggle('md:flex', items.length > 1));
    };

    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[data-lightbox]');
        if (!link || e.defaultPrevented || e.ctrlKey || e.metaKey) return;
        e.preventDefault();
        // Satu foto bisa muncul dua kali (carousel beranda), jadi ambil yang unik per URL
        const seen = new Set();
        items = [...document.querySelectorAll(`a[data-lightbox="${link.dataset.lightbox}"]`)]
            .filter((a) => !seen.has(a.href) && seen.add(a.href));
        show(items.findIndex((a) => a.href === link.href));
        dialog.showModal();
        document.documentElement.classList.add('overflow-hidden');
    });

    const cleanup = () => {
        document.documentElement.classList.remove('overflow-hidden');
        image.removeAttribute('src');
    };

    const hide = () => {
        dialog.close();
        cleanup();
    };

    // Esc menutup dialog secara native
    dialog.addEventListener('cancel', cleanup);
    dialog.addEventListener('close', cleanup);

    dialog.querySelector('[data-lightbox-close]').addEventListener('click', hide);
    prevBtn.addEventListener('click', () => show(index - 1));
    nextBtn.addEventListener('click', () => show(index + 1));

    // Klik area gelap di luar foto untuk menutup
    dialog.addEventListener('click', (e) => {
        if (e.target === dialog) hide();
    });

    dialog.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') show(index - 1);
        if (e.key === 'ArrowRight') show(index + 1);
    });

    // Swipe kiri/kanan di layar sentuh
    let startX = null;
    dialog.addEventListener('pointerdown', (e) => {
        if (e.pointerType !== 'mouse') startX = e.clientX;
    });
    dialog.addEventListener('pointerup', (e) => {
        if (startX === null) return;
        const dx = e.clientX - startX;
        startX = null;
        if (Math.abs(dx) > 50 && items.length > 1) show(dx < 0 ? index + 1 : index - 1);
    });
}
