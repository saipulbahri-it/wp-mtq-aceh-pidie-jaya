/**
 * MTQ Gallery Lightbox - Simple & Clean
 * Lightbox gallery system yang sederhana, kecil, dan stabil.
 *
 * @package MTQ_Aceh_Pidie_Jaya
 * @author @saipulbahri-it
 * @version 2.1
 */

(function() {
  // Global state
  const state = {
    images: [],
    currentIndex: 0,
    isOpen: false
  };

  // Create modal once
  function ensureModal() {
    if (document.getElementById('mtq-lightbox')) return;

    const html = [
      '<div id="mtq-lightbox" class="fixed inset-0 bg-black bg-opacity-95 hidden opacity-0 transition-opacity duration-200" style="z-index:100000">',
      '  <div class="absolute inset-0" data-close="true"></div>',
  '  <div class="relative z-10 w-full h-full flex items-center justify-center p-4">',
      '    <button id="mtq-close" class="absolute top-4 right-4 text-white hover:text-red-400 bg-black/60 rounded-full p-2" aria-label="Tutup">',
      '      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">',
      '        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
      '      </svg>',
      '    </button>',
  '    <button id="mtq-prev" class="absolute left-6 top-1/2 -translate-y-1/2 text-white hover:text-blue-400 bg-black/60 rounded-full p-3 hidden" aria-label="Sebelumnya">',
      '      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">',
      '        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>',
      '      </svg>',
      '    </button>',
  '    <button id="mtq-next" class="absolute right-6 top-1/2 -translate-y-1/2 text-white hover:text-blue-400 bg-black/60 rounded-full p-3 hidden" aria-label="Berikutnya">',
      '      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">',
      '        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>',
      '      </svg>',
      '    </button>',
  '    <div class="relative flex items-center justify-center max-w-[90vw] max-h-[85vh] lg:max-w-[75vw] lg:max-h-[80vh] rounded-2xl overflow-hidden shadow-2xl">',
      '      <div id="mtq-loading" class="flex flex-col items-center justify-center">',
      '        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-white mb-3"></div>',
      '        <p class="text-white text-xs">Memuat gambar...</p>',
      '      </div>',
  '      <img id="mtq-image" class="max-w-full max-h-full object-contain transition-transform duration-300 cursor-zoom-in" style="display:none" />',
  '      <div id="mtq-info" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-4 text-center z-[1]" style="display:none">',
      '        <h3 id="mtq-title" class="text-base font-semibold mb-1"></h3>',
      '        <p id="mtq-counter" class="text-xs text-gray-300"></p>',
      '      </div>',
      '    </div>',
      '  </div>',
      '</div>'
    ].join('');

    document.body.insertAdjacentHTML('beforeend', html);

    // Wiring
    const modal = document.getElementById('mtq-lightbox');
    modal.addEventListener('click', (e) => {
      if (e.target.dataset.close === 'true') close();
    });

    document.getElementById('mtq-close').addEventListener('click', close);
    document.getElementById('mtq-prev').addEventListener('click', () => navigate(-1));
    document.getElementById('mtq-next').addEventListener('click', () => navigate(1));

    document.addEventListener('keydown', (e) => {
      if (!state.isOpen) return;
      if (e.key === 'Escape') return close();
      if (e.key === 'ArrowLeft') { e.preventDefault(); return navigate(-1); }
      if (e.key === 'ArrowRight') { e.preventDefault(); return navigate(1); }
    });
  }

  function open(src, title = '', images = []) {
    ensureModal();

    if (images.length) {
      state.images = images;
      const idx = images.findIndex(i => i.src === src);
      state.currentIndex = idx >= 0 ? idx : 0;
    } else {
      state.images = [{ src, title }];
      state.currentIndex = 0;
    }

    state.isOpen = true;
    document.body.style.overflow = 'hidden';

    const modal = document.getElementById('mtq-lightbox');
    modal.classList.remove('hidden');
    requestAnimationFrame(() => modal.classList.remove('opacity-0'));

    loadCurrent();
    updateNav();
  }

  function close() {
    const modal = document.getElementById('mtq-lightbox');
    if (!modal) return;
    modal.classList.add('opacity-0');
    setTimeout(() => {
      modal.classList.add('hidden');
      document.body.style.overflow = '';
      state.isOpen = false;
    }, 200);
  }

  function loadCurrent() {
    const imgData = state.images[state.currentIndex];
    if (!imgData) return;

    const loading = document.getElementById('mtq-loading');
    const image = document.getElementById('mtq-image');
    const info = document.getElementById('mtq-info');
    const titleEl = document.getElementById('mtq-title');
    const counterEl = document.getElementById('mtq-counter');

    loading.style.display = 'flex';
    image.style.display = 'none';
    info.style.display = 'none';

    const pre = new Image();
    pre.onload = function() {
      image.src = pre.src;
      image.alt = imgData.title || '';
      loading.style.display = 'none';
      image.style.display = 'block';

      const hasTitle = imgData.title && imgData.title.trim() !== '';
      const hasMultiple = state.images.length > 1;
      if (hasTitle || hasMultiple) {
        titleEl.textContent = hasTitle ? imgData.title : '';
        counterEl.textContent = hasMultiple ? `${state.currentIndex + 1} dari ${state.images.length}` : '';
        info.style.display = 'block';
      }
    };
    pre.onerror = function() {
      loading.style.display = 'none';
      info.style.display = 'block';
      titleEl.textContent = 'Error: Gambar gagal dimuat';
      counterEl.textContent = '';
    };
    pre.src = imgData.src;
  }

  function navigate(dir) {
    if (state.images.length <= 1) return;
    state.currentIndex += dir;
    if (state.currentIndex >= state.images.length) state.currentIndex = 0;
    if (state.currentIndex < 0) state.currentIndex = state.images.length - 1;
    loadCurrent();
    updateNav();
  }

  function updateNav() {
    const prev = document.getElementById('mtq-prev');
    const next = document.getElementById('mtq-next');
    if (!prev || !next) return;

    if (state.images.length > 1) {
      prev.classList.remove('hidden');
      next.classList.remove('hidden');
    } else {
      prev.classList.add('hidden');
      next.classList.add('hidden');
    }
  }

  function init() {
    // Cari semua container gallery umum termasuk Gutenberg galleries
    const containers = document.querySelectorAll(
      '.mtq-gallery-grid, .gallery-grid-container, #gallery-grid, .mtq-gallery-slider, .mtq-gallery-masonry, .gallery-container, .wp-block-gallery'
    );

    containers.forEach(container => {
      const items = container.querySelectorAll(
        '.gallery-thumbnail, .image-gallery-item, .gallery-item img, [data-image-src], .wp-block-image img, .wp-block-image a img, .wp-block-gallery a img, .blocks-gallery-item a img'
      );
      if (!items.length) return;

      const images = [];
      items.forEach(item => {
        const anchorHref = item.tagName === 'IMG' ? (item.closest('a')?.getAttribute('href') || '') : '';
        const src = item.getAttribute('data-image-src') || item.getAttribute('data-src') || anchorHref || item.src || item.getAttribute('href');
        const figcap = item.closest('figure')?.querySelector('figcaption')?.textContent?.trim() || '';
        const title = item.getAttribute('data-image-title') || item.getAttribute('data-title') || item.alt || item.closest('.gallery-item')?.getAttribute('data-title') || figcap || '';
        if (src && !src.startsWith('data:')) images.push({ src, title });
      });

      items.forEach(el => {
        const isGalleryItem = el.hasAttribute('data-image-src') || el.classList.contains('gallery-thumbnail') || el.classList.contains('image-gallery-item') || el.tagName === 'IMG';
        if (!isGalleryItem) return;
        el.style.cursor = 'pointer';
        el.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();
          const anchorHref = el.tagName === 'IMG' ? (el.closest('a')?.getAttribute('href') || '') : '';
          const src = el.getAttribute('data-image-src') || el.getAttribute('data-src') || anchorHref || el.src || el.getAttribute('href');
          const figcap = el.closest('figure')?.querySelector('figcaption')?.textContent?.trim() || '';
          const title = el.getAttribute('data-image-title') || el.getAttribute('data-title') || el.alt || el.closest('.gallery-item')?.getAttribute('data-title') || figcap || '';
          if (src && !src.startsWith('data:')) open(src, title, images);
        });
      });
    });

    // Standalone items (di luar container)
    const standalone = document.querySelectorAll('.gallery-thumbnail, .image-gallery-item, .wp-block-image a img, .wp-block-image img, .wp-block-gallery a img');
    standalone.forEach(el => {
      if (el.closest('.mtq-gallery-grid, .gallery-grid-container, #gallery-grid, .mtq-gallery-slider, .mtq-gallery-masonry, .gallery-container, .wp-block-gallery')) return;
      el.style.cursor = 'pointer';
      el.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const anchorHref = el.tagName === 'IMG' ? (el.closest('a')?.getAttribute('href') || '') : '';
        const src = el.getAttribute('data-image-src') || el.getAttribute('data-src') || anchorHref || el.src;
        const figcap = el.closest('figure')?.querySelector('figcaption')?.textContent?.trim() || '';
        const title = el.getAttribute('data-image-title') || el.getAttribute('data-title') || el.alt || figcap || '';
        if (src && !src.startsWith('data:')) open(src, title);
      });
    });
  }

  // Auto init
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Expose globals for theme usage
  window.openLightbox = open;
  window.closeLightbox = close;
  window.navigateGallery = navigate;
  window.initializeGallery = init;
})();
