// Carousel berbasis CSS scroll-snap: swipe di HP sudah native,
// script ini menambahkan tombol panah dan drag dengan mouse di desktop.
export function initCarousels(root = document) {
    root.querySelectorAll('[data-carousel]').forEach(setupCarousel);
}

function setupCarousel(carousel) {
    const track = carousel.querySelector('[data-carousel-track]');
    const prev = carousel.querySelector('[data-carousel-prev]');
    const next = carousel.querySelector('[data-carousel-next]');
    const loop = carousel.hasAttribute('data-carousel-loop');

    const atStart = () => track.scrollLeft <= 1;
    const atEnd = () => track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;

    prev?.addEventListener('click', () => {
        if (loop && atStart()) {
            track.scrollTo({ left: track.scrollWidth });
        } else {
            track.scrollBy({ left: -track.clientWidth });
        }
    });

    next?.addEventListener('click', () => {
        if (loop && atEnd()) {
            track.scrollTo({ left: 0 });
        } else {
            track.scrollBy({ left: track.clientWidth });
        }
    });

    const updateButtons = () => {
        const scrollable = track.scrollWidth > track.clientWidth + 1;
        [prev, next].forEach((btn) => btn && btn.classList.toggle('md:flex', scrollable));
        if (prev) prev.disabled = !loop && atStart();
        if (next) next.disabled = !loop && atEnd();
    };

    track.addEventListener('scroll', updateButtons, { passive: true });
    window.addEventListener('resize', updateButtons);
    updateButtons();

    track.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') next?.click();
        if (e.key === 'ArrowLeft') prev?.click();
    });

    enableMouseDrag(track);
}

function enableMouseDrag(track) {
    let startX = 0;
    let startScroll = 0;
    let dragging = false;
    let moved = false;

    track.addEventListener('pointerdown', (e) => {
        if (e.pointerType !== 'mouse' || e.button !== 0) return;
        dragging = true;
        moved = false;
        startX = e.clientX;
        startScroll = track.scrollLeft;
    });

    track.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - startX;
        if (!moved && Math.abs(dx) > 5) {
            moved = true;
            // Matikan snap & smooth selama drag supaya gerakan mengikuti mouse
            track.style.scrollSnapType = 'none';
            track.style.scrollBehavior = 'auto';
            track.setPointerCapture(e.pointerId);
            track.classList.add('cursor-grabbing', 'select-none');
        }
        if (moved) track.scrollLeft = startScroll - dx;
    });

    const endDrag = () => {
        if (!dragging) return;
        dragging = false;
        if (!moved) return;
        track.classList.remove('cursor-grabbing', 'select-none');
        // Kembalikan snap supaya berhenti rapi di item terdekat
        track.style.scrollBehavior = '';
        track.style.scrollSnapType = '';
    };

    track.addEventListener('pointerup', endDrag);
    track.addEventListener('pointercancel', endDrag);

    // Jangan buka link kalau user sebenarnya sedang men-drag
    track.addEventListener('click', (e) => {
        if (moved) {
            e.preventDefault();
            e.stopPropagation();
            moved = false;
        }
    }, true);

    track.addEventListener('dragstart', (e) => e.preventDefault());
}
