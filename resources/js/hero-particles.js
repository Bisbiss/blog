// particles.js memakai `arguments.callee`, yang dilarang di strict mode ES module,
// jadi tidak bisa di-import sebagai modul. Vite tetap menyalin filenya ke build
// (import ?url) dan kita memuatnya sebagai script klasik saat dibutuhkan.
import particlesScriptUrl from 'particles.js/particles.js?url';

let loading;

function loadParticlesJs() {
    if (typeof window.particlesJS === 'function') return Promise.resolve();

    loading ??= new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = particlesScriptUrl;
        script.onload = resolve;
        script.onerror = () => reject(new Error('particles.js gagal dimuat'));
        document.head.appendChild(script);
    });

    return loading;
}

// Partikel amber halus di latar hero. Dilewati kalau pengguna mengatur
// "kurangi gerakan" di perangkatnya, supaya tidak mengganggu.
export async function initHeroParticles() {
    const container = document.getElementById('hero-particles');
    if (!container) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    try {
        await loadParticlesJs();
    } catch (error) {
        console.warn(error.message);
        return;
    }

    const isMobile = window.innerWidth < 768;

    window.particlesJS('hero-particles', {
        particles: {
            number: {
                value: isMobile ? 25 : 55,
                density: { enable: true, value_area: 900 },
            },
            color: { value: '#f59e0b' }, // amber-500, warna primary situs
            shape: { type: 'circle' },
            opacity: {
                value: 0.45,
                random: true,
                anim: { enable: true, speed: 0.6, opacity_min: 0.15, sync: false },
            },
            size: {
                value: 3,
                random: true,
                anim: { enable: false },
            },
            line_linked: {
                enable: true,
                distance: 140,
                color: '#f59e0b',
                opacity: 0.22,
                width: 1,
            },
            move: {
                enable: true,
                speed: 1.1,
                direction: 'none',
                random: true,
                straight: false,
                out_mode: 'out',
                bounce: false,
            },
        },
        interactivity: {
            // Dengarkan mouse di window supaya canvas bisa tetap pointer-events: none
            // dan tombol/link di hero tetap bisa diklik.
            detect_on: 'window',
            events: {
                onhover: { enable: !isMobile, mode: 'grab' },
                onclick: { enable: false },
                resize: true,
            },
            modes: {
                grab: {
                    distance: 160,
                    line_linked: { opacity: 0.5 },
                },
            },
        },
        retina_detect: true,
    });

    // particles.js hanya mengukur ulang canvas saat jendela di-resize, padahal tinggi hero
    // masih berubah saat foto selesai dimuat. Pantau ukuran container dan picu handler-nya.
    if ('ResizeObserver' in window) {
        let frame;
        new ResizeObserver(() => {
            cancelAnimationFrame(frame);
            frame = requestAnimationFrame(() => window.dispatchEvent(new Event('resize')));
        }).observe(container);
    }
}
