/**
 * Arena Page JavaScript Module
 * Handles arena-specific gallery functionality separate from main gallery.js
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 * @author @saipulbahri-it
 */

// Prevent multiple loading of arena module
if (typeof window.MTQArenaModule === 'undefined') {
  window.MTQArenaModule = true;

  // Arena Gallery Modal State
  const arenaModalState = {
    images: [],
    currentIndex: 0,
    zoom: 1,
    isFullscreen: false,
    isDragging: false,
    dragStart: { x: 0, y: 0 },
    dragCurrent: { x: 0, y: 0 }
  };

/**
 * Open Arena Image Modal
 */
function openArenaImageModal(imageSrc, imageTitle, arenaImages = []) {
  console.log('Opening arena image modal:', { imageSrc, imageTitle, arenaImages: arenaImages.length });
  
  // Wait a bit to ensure DOM is ready
  setTimeout(() => {
    const modal = document.getElementById("arena-image-modal");
    const modalImage = document.getElementById("arena-modal-image");
    const modalTitle = document.getElementById("arena-modal-title");
    const modalCaption = document.getElementById("arena-modal-caption");
    const modalLoading = document.getElementById("arena-modal-loading");
    
    // Check if required elements exist
    if (!modal || !modalImage || !modalTitle || !modalCaption || !modalLoading) {
      console.error('Arena modal elements not found:', {
        modal: !!modal,
        modalImage: !!modalImage,
        modalTitle: !!modalTitle,
        modalCaption: !!modalCaption,
        modalLoading: !!modalLoading
      });
      return;
    }
    
    // Initialize arena images if provided
    if (arenaImages.length > 0) {
      arenaModalState.images = arenaImages;
      arenaModalState.currentIndex = arenaImages.findIndex(img => img.src === imageSrc);
      if (arenaModalState.currentIndex === -1) arenaModalState.currentIndex = 0;
    } else {
      arenaModalState.images = [{src: imageSrc, title: imageTitle}];
      arenaModalState.currentIndex = 0;
    }
    
    // Reset modal state
    resetArenaModalState();
    
    // Show modal with loading state
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    modalLoading.style.display = "flex";
    modalImage.style.display = "none";
    modalCaption.style.display = "none";
    
    // Hide title container initially
    const modalTitleContainer = document.getElementById("arena-modal-title-container");
    if (modalTitleContainer) {
      modalTitleContainer.style.display = "none";
    }
    
    // Set title
    modalTitle.textContent = imageTitle;
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = "hidden";
    
    // Add navigation buttons if there are multiple images
    addArenaNavigationButtons();
    
    // Load image
    loadArenaModalImage(imageSrc, imageTitle);
    
    // Add enhanced event listeners
    addArenaEnhancedEventListeners();
  }, 10); // Small delay to ensure DOM is ready
}

/**
 * Load Arena Modal Image with Error Handling
 */
function loadArenaModalImage(imageSrc, imageTitle) {
  // Use querySelectorAll as fallback to check if elements exist in DOM
  const modalImage = document.getElementById("arena-modal-image") || document.querySelector("#arena-modal-image");
  const modalTitle = document.getElementById("arena-modal-title") || document.querySelector("#arena-modal-title");
  const modalCaption = document.getElementById("arena-modal-caption") || document.querySelector("#arena-modal-caption");
  const modalLoading = document.getElementById("arena-modal-loading") || document.querySelector("#arena-modal-loading");
  
  console.log('loadArenaModalImage - checking elements:', {
    modalImage: !!modalImage,
    modalTitle: !!modalTitle,
    modalCaption: !!modalCaption,
    modalLoading: !!modalLoading,
    modalTitleInDOM: !!document.querySelector("#arena-modal-title"),
    allArenaElements: document.querySelectorAll("[id*='arena-modal']").length
  });
  
  // Check if required elements exist
  if (!modalImage || !modalTitle || !modalCaption || !modalLoading) {
    console.error('Arena modal elements not found:', {
      modalImage: !!modalImage,
      modalTitle: !!modalTitle,
      modalCaption: !!modalCaption,
      modalLoading: !!modalLoading
    });
    
    // Try to find elements with more detailed inspection
    console.log('Detailed DOM inspection:');
    console.log('arena-modal-image element:', document.getElementById("arena-modal-image"));
    console.log('arena-modal-title element:', document.getElementById("arena-modal-title"));
    console.log('arena-modal-caption element:', document.getElementById("arena-modal-caption"));
    console.log('arena-modal-loading element:', document.getElementById("arena-modal-loading"));
    
    return;
  }
  
  modalLoading.style.display = "flex";
  modalImage.style.display = "none";
  
  const img = new Image();
  
  img.onload = function() {
    // Re-check elements exist (DOM might have changed)
    const currentModalImage = document.getElementById("arena-modal-image");
    const currentModalTitle = document.getElementById("arena-modal-title");
    const currentModalTitleContainer = document.getElementById("arena-modal-title-container");
    const currentModalCaption = document.getElementById("arena-modal-caption");
    const currentModalLoading = document.getElementById("arena-modal-loading");
    
    if (!currentModalImage || !currentModalTitle || !currentModalCaption || !currentModalLoading) {
      console.error('Arena modal elements not found in onload callback:', {
        currentModalImage: !!currentModalImage,
        currentModalTitle: !!currentModalTitle,
        currentModalTitleContainer: !!currentModalTitleContainer,
        currentModalCaption: !!currentModalCaption,
        currentModalLoading: !!currentModalLoading
      });
      return;
    }
    
    currentModalImage.src = this.src;
    currentModalImage.alt = imageTitle;
    currentModalTitle.textContent = imageTitle;
    
    currentModalLoading.style.display = "none";
    currentModalImage.style.display = "block";
    
    // Show title container
    if (currentModalTitleContainer) {
      currentModalTitleContainer.style.display = "block";
    }
    
    // Show caption
    currentModalCaption.style.display = "block";
    
    // Update image counter
    updateArenaImageCounter();
    
    // Reset zoom and transform
    resetArenaImageTransform();
  };
  
  img.onerror = function() {
    // Re-check elements exist for error handling
    const currentModalLoading = document.getElementById("arena-modal-loading");
    const currentModalTitle = document.getElementById("arena-modal-title");
    const currentModalCaption = document.getElementById("arena-modal-caption");
    
    if (currentModalLoading) {
      currentModalLoading.style.display = "none";
    }
    if (currentModalTitle) {
      currentModalTitle.textContent = "Error Loading Arena Image";
    }
    if (currentModalCaption) {
      currentModalCaption.innerHTML = `
        <div class="text-center text-red-400">
          <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p>Gagal memuat gambar arena</p>
          <button onclick="closeArenaImageModal()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Tutup</button>
        </div>
      `;
      currentModalCaption.style.display = "block";
    }
  };
  
  img.src = imageSrc;
}

/**
 * Reset Arena Modal State
 */
function resetArenaModalState() {
  const modalImage = document.getElementById("arena-modal-image");
  const defaultZoom = getDefaultArenaZoom();
  arenaModalState.zoom = defaultZoom;
  arenaModalState.isFullscreen = false;
  arenaModalState.isDragging = false;
  resetArenaImageTransform();
}

/**
 * Reset Arena Image Transform
 */
function resetArenaImageTransform() {
  const modalImage = document.getElementById("arena-modal-image");
  if (modalImage) {
    // Intelligent default zoom based on screen size
    const defaultZoom = getDefaultArenaZoom();
    modalImage.style.transform = `scale(${defaultZoom}) translate(0, 0)`;
    arenaModalState.zoom = defaultZoom;
  }
}

/**
 * Get Default Arena Zoom based on screen size
 */
function getDefaultArenaZoom() {
  const screenWidth = window.innerWidth;
  const screenHeight = window.innerHeight;
  
  // Desktop (large screens) - smaller default zoom for better overview
  if (screenWidth >= 1024) {
    return 0.75; // 75% untuk desktop
  }
  // Tablet
  else if (screenWidth >= 768) {
    return 0.85; // 85% untuk tablet
  }
  // Mobile
  else {
    return 1.0; // 100% untuk mobile
  }
}

/**
 * Add Arena Navigation Buttons
 */
function addArenaNavigationButtons() {
  const modal = document.getElementById("arena-image-modal");
  const prevBtn = document.getElementById("arena-modal-prev");
  const nextBtn = document.getElementById("arena-modal-next");
  
  console.log('Adding arena navigation buttons:', {
    modal: !!modal,
    prevBtn: !!prevBtn,
    nextBtn: !!nextBtn,
    imagesCount: arenaModalState.images.length
  });
  
  if (arenaModalState.images.length > 1) {
    if (prevBtn) {
      prevBtn.classList.remove("hidden");
      prevBtn.style.display = "flex";
    }
    if (nextBtn) {
      nextBtn.classList.remove("hidden");
      nextBtn.style.display = "flex";
    }
    
    // Add click listeners if not already added
    if (prevBtn && !prevBtn.hasAttribute('data-arena-listener-added')) {
      console.log('Adding prev button listener');
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Prev button clicked');
        navigateArenaImage(-1);
      });
      prevBtn.setAttribute('data-arena-listener-added', 'true');
    }
    
    if (nextBtn && !nextBtn.hasAttribute('data-arena-listener-added')) {
      console.log('Adding next button listener');
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Next button clicked');
        navigateArenaImage(1);
      });
      nextBtn.setAttribute('data-arena-listener-added', 'true');
    }
  } else {
    if (prevBtn) {
      prevBtn.classList.add("hidden");
      prevBtn.style.display = "none";
    }
    if (nextBtn) {
      nextBtn.classList.add("hidden");
      nextBtn.style.display = "none";
    }
  }
}

/**
 * Update Arena Image Counter
 */
function updateArenaImageCounter() {
  const counter = document.getElementById("arena-modal-counter");
  if (counter && arenaModalState.images.length > 1) {
    counter.textContent = `${arenaModalState.currentIndex + 1} / ${arenaModalState.images.length}`;
  }
}

/**
 * Navigate Arena Images
 */
function navigateArenaImage(direction) {
  console.log('Navigate arena image called:', {
    direction,
    currentIndex: arenaModalState.currentIndex,
    totalImages: arenaModalState.images.length,
    images: arenaModalState.images
  });
  
  if (arenaModalState.images.length <= 1) {
    console.log('Only one image, navigation disabled');
    return;
  }
  
  arenaModalState.currentIndex += direction;
  
  if (arenaModalState.currentIndex >= arenaModalState.images.length) {
    arenaModalState.currentIndex = 0;
  } else if (arenaModalState.currentIndex < 0) {
    arenaModalState.currentIndex = arenaModalState.images.length - 1;
  }
  
  const currentImage = arenaModalState.images[arenaModalState.currentIndex];
  console.log('Loading new image:', currentImage);
  loadArenaModalImage(currentImage.src, currentImage.title);
}

/**
 * Zoom Arena Image
 */
function zoomArenaImage(direction) {
  const modalImage = document.getElementById("arena-modal-image");
  if (!modalImage) return;
  
  arenaModalState.zoom += direction * 0.25;
  arenaModalState.zoom = Math.max(0.5, Math.min(arenaModalState.zoom, 3));
  
  modalImage.style.transform = `scale(${arenaModalState.zoom})`;
}

/**
 * Toggle Arena Fullscreen
 */
function toggleArenaFullscreen() {
  const modal = document.getElementById("arena-image-modal");
  
  if (!arenaModalState.isFullscreen) {
    if (modal.requestFullscreen) {
      modal.requestFullscreen();
    } else if (modal.webkitRequestFullscreen) {
      modal.webkitRequestFullscreen();
    } else if (modal.msRequestFullscreen) {
      modal.msRequestFullscreen();
    }
    arenaModalState.isFullscreen = true;
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
    arenaModalState.isFullscreen = false;
  }
}

/**
 * Add Arena Enhanced Event Listeners
 */
function addArenaEnhancedEventListeners() {
  const modalImage = document.getElementById("arena-modal-image");
  
  if (modalImage && !modalImage.hasAttribute('data-arena-listeners-added')) {
    // Double click to zoom
    modalImage.addEventListener('dblclick', () => {
      if (arenaModalState.zoom === 1) {
        zoomArenaImage(1);
      } else {
        resetArenaImageTransform();
      }
    });
    
    // Mouse wheel zoom
    modalImage.addEventListener('wheel', (e) => {
      e.preventDefault();
      zoomArenaImage(e.deltaY > 0 ? -1 : 1);
    });
    
    // Touch gestures for mobile
    let touchStartDistance = 0;
    
    modalImage.addEventListener('touchstart', (e) => {
      if (e.touches.length === 2) {
        touchStartDistance = Math.hypot(
          e.touches[0].pageX - e.touches[1].pageX,
          e.touches[0].pageY - e.touches[1].pageY
        );
      }
    });
    
    modalImage.addEventListener('touchmove', (e) => {
      if (e.touches.length === 2) {
        e.preventDefault();
        const touchDistance = Math.hypot(
          e.touches[0].pageX - e.touches[1].pageX,
          e.touches[0].pageY - e.touches[1].pageY
        );
        
        const scale = touchDistance / touchStartDistance;
        arenaModalState.zoom = Math.max(0.5, Math.min(arenaModalState.zoom * scale, 3));
        modalImage.style.transform = `scale(${arenaModalState.zoom})`;
        touchStartDistance = touchDistance;
      }
    });
    
    modalImage.setAttribute('data-arena-listeners-added', 'true');
  }
}

/**
 * Close Arena Image Modal
 */
function closeArenaImageModal() {
  const modal = document.getElementById("arena-image-modal");
  const modalTitleContainer = document.getElementById("arena-modal-title-container");
  
  if (modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    
    // Hide title container
    if (modalTitleContainer) {
      modalTitleContainer.style.display = "none";
    }
    
    // Restore body scroll
    document.body.style.overflow = "";
    
    // Reset modal state
    resetArenaModalState();
    
    // Exit fullscreen if active
    if (arenaModalState.isFullscreen) {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
      arenaModalState.isFullscreen = false;
    }
  }
}

/**
 * Initialize Arena Gallery Collections
 */
function initializeArenaGalleryCollections() {
  // Group arena gallery items by their parent container
  const arenaGalleryContainers = document.querySelectorAll(".arena-gallery-grid, .arena-gallery-container, #arena-gallery-grid, .mtq-gallery-grid");
  
  arenaGalleryContainers.forEach(container => {
    const arenaGalleryItems = container.querySelectorAll(".arena-gallery-item, .arena-image-item, [data-arena-image-src]");
    
    if (arenaGalleryItems.length > 0) {
      // Create collection of images for this arena gallery
      const arenaImages = Array.from(arenaGalleryItems).map(item => {
        // Handle different data attribute formats
        let src = item.getAttribute("data-arena-image-src") || 
                 item.getAttribute("data-image-src") || 
                 item.getAttribute("data-src") || 
                 item.src || 
                 item.getAttribute("href");
        
        let title = item.getAttribute("data-arena-image-title") || 
                   item.getAttribute("data-image-title") || 
                   item.getAttribute("data-title") || 
                   item.alt || 
                   item.closest('.arena-gallery-item')?.getAttribute('data-title') || 
                   "Arena Image";
        
        return { src, title };
      }).filter(img => img.src); // Only include items with valid src
      
      // Add click listeners with arena gallery collection support
      arenaGalleryItems.forEach((item, index) => {
        item.addEventListener("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          let imageSrc = this.getAttribute("data-arena-image-src") || 
                        this.getAttribute("data-image-src") || 
                        this.getAttribute("data-src") || 
                        this.src || 
                        this.getAttribute("href");
          
          let imageTitle = this.getAttribute("data-arena-image-title") || 
                          this.getAttribute("data-image-title") || 
                          this.getAttribute("data-title") || 
                          this.alt || 
                          this.closest('.arena-gallery-item')?.getAttribute('data-title') || 
                          "Arena Image";
          
          if (imageSrc) {
            // Find the current image index in the arena gallery
            const currentIndex = arenaImages.findIndex(img => img.src === imageSrc);
            if (currentIndex !== -1) {
              arenaModalState.currentIndex = currentIndex;
            }
            
            openArenaImageModal(imageSrc, imageTitle, arenaImages);
          }
        });
      });
    }
  });
}

/**
 * Initialize Arena Gallery Module
 */
function initializeArenaGallery() {
  console.log('Initializing Arena Gallery...');
  
  // Check all required modal elements
  const modal = document.getElementById("arena-image-modal");
  const modalImage = document.getElementById("arena-modal-image");
  const modalTitle = document.getElementById("arena-modal-title");
  const modalTitleContainer = document.getElementById("arena-modal-title-container");
  const modalCaption = document.getElementById("arena-modal-caption");
  const modalLoading = document.getElementById("arena-modal-loading");
  const closeBtn = document.getElementById("arena-modal-close");
  const zoomBtn = document.getElementById("arena-zoom-btn");
  const prevBtn = document.getElementById("arena-modal-prev");
  const nextBtn = document.getElementById("arena-modal-next");
  
  console.log('Arena modal elements check:', {
    modal: !!modal,
    modalImage: !!modalImage,
    modalTitle: !!modalTitle,
    modalTitleContainer: !!modalTitleContainer,
    modalCaption: !!modalCaption,
    modalLoading: !!modalLoading,
    closeBtn: !!closeBtn,
    zoomBtn: !!zoomBtn,
    prevBtn: !!prevBtn,
    nextBtn: !!nextBtn
  });
  
  // Arena modal close on background click
  if (modal) {
    modal.addEventListener("click", function(e) {
      if (e.target === modal || e.target.classList.contains('arena-image-modal-overlay')) {
        closeArenaImageModal();
      }
    });
  }
  
  // Arena modal close button
  if (closeBtn) {
    closeBtn.addEventListener("click", closeArenaImageModal);
  }
  
  // Arena zoom button
  if (zoomBtn) {
    zoomBtn.addEventListener("click", function() {
      const defaultZoom = getDefaultArenaZoom();
      if (arenaModalState.zoom === defaultZoom) {
        zoomArenaImage(1);
      } else {
        resetArenaImageTransform();
      }
    });
  }
  
  // Arena keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (modal && !modal.classList.contains('hidden')) {
      switch(e.key) {
        case 'Escape':
          closeArenaImageModal();
          break;
        case 'ArrowLeft':
          navigateArenaImage(-1);
          break;
        case 'ArrowRight':
          navigateArenaImage(1);
          break;
        case ' ': // Spacebar for zoom
          e.preventDefault();
          const defaultZoom = getDefaultArenaZoom();
          if (arenaModalState.zoom === defaultZoom) {
            zoomArenaImage(1);
          } else {
            resetArenaImageTransform();
          }
          break;
      }
    }
  });
  
  // Initialize arena gallery collections
  initializeArenaGalleryCollections();
  
  // Handle window resize to adjust zoom
  window.addEventListener('resize', function() {
    const modal = document.getElementById("arena-image-modal");
    if (modal && !modal.classList.contains('hidden')) {
      // Only adjust if modal is open and zoom is at default level
      const defaultZoom = getDefaultArenaZoom();
      if (Math.abs(arenaModalState.zoom - 1) < 0.1 || Math.abs(arenaModalState.zoom - 0.75) < 0.1 || Math.abs(arenaModalState.zoom - 0.85) < 0.1) {
        console.log('Adjusting zoom for new screen size:', defaultZoom);
        resetArenaImageTransform();
      }
    }
  });
}

// Auto-initialize when DOM is ready with retry mechanism
function tryInitializeArenaGallery(maxRetries = 5, delay = 100) {
  let retryCount = 0;
  
  function attemptInit() {
    console.log(`Arena gallery init attempt ${retryCount + 1}/${maxRetries}`);
    
    // Check if modal exists
    const modal = document.getElementById("arena-image-modal");
    const modalTitle = document.getElementById("arena-modal-title");
    
    if (modal && modalTitle) {
      console.log('Arena modal elements found, initializing...');
      initializeArenaGallery();
      return;
    }
    
    retryCount++;
    if (retryCount < maxRetries) {
      console.log(`Arena modal not ready, retrying in ${delay}ms...`);
      setTimeout(attemptInit, delay);
    } else {
      console.error('Failed to initialize arena gallery after maximum retries');
    }
  }
  
  attemptInit();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => tryInitializeArenaGallery());
} else {
  tryInitializeArenaGallery();
}

// Export functions for global access
window.openArenaImageModal = openArenaImageModal;
window.closeArenaImageModal = closeArenaImageModal;
window.navigateArenaImage = navigateArenaImage;
window.zoomArenaImage = zoomArenaImage;
window.toggleArenaFullscreen = toggleArenaFullscreen;
window.initializeArenaGallery = initializeArenaGallery;

} // End MTQArenaModule wrapper
