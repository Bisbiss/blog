import './bootstrap';
import { initCarousels } from './carousel';
import { initLightbox } from './lightbox';
import { initReveal } from './reveal';
import { initBackToTop, initCopyLink } from './ui';
import { initHeroParticles } from './hero-particles';

document.addEventListener('DOMContentLoaded', () => {
    initCarousels();
    initLightbox();
    initReveal();
    initBackToTop();
    initCopyLink();
    initHeroParticles();
});
