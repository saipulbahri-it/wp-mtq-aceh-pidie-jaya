/**
 * MTQ Gallery JavaScript Module
 * Handles image modal, lightbox, and gallery interactions
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 * @author @saipulbahri-it
 */

// Gallery Modal State
const modalState = {
  images: [],
  currentIndex: 0,
  zoom: 1,
  isFullscreen: false,
  isDragging: false,
  dragStart: { x: 0, y: 0 },
  dragCurrent: { x: 0, y: 0 }
};

/**
 * Open Image Modal with Gallery Support
 */
function openImageModal(imageSrc, imageTitle, galleryImages = []) {
  // Use timeout to ensure DOM is ready
  setTimeout(() => {
    const modal = document.getElementById("image-modal");
    const modalImage = document.getElementById("modal-image");
    const modalTitle = document.getElementById("modal-title");
    const modalCaption = document.getElementById("modal-caption");
    const modalLoading = document.getElementById("modal-loading");
    
    console.log('openImageModal - checking elements:', {
      modal: !!modal,
      modalImage: !!modalImage,
      modalTitle: !!modalTitle,
      modalCaption: !!modalCaption,
      modalLoading: !!modalLoading,
      imageSrc: imageSrc,
      imageTitle: imageTitle
    });
    
    // Enhanced null checking
    if (!modal || !modalImage || !modalTitle || !modalCaption || !modalLoading) {
      console.error('Gallery modal elements not found:', {
        modal: !!modal,
        modalImage: !!modalImage,
        modalTitle: !!modalTitle,
        modalCaption: !!modalCaption,
        modalLoading: !!modalLoading
      });
      return;
    }
    
    // Initialize gallery images if provided
    if (galleryImages.length > 0) {
      modalState.images = galleryImages;
      modalState.currentIndex = galleryImages.findIndex(img => img.src === imageSrc);
      if (modalState.currentIndex === -1) modalState.currentIndex = 0;
    } else {
      modalState.images = [{src: imageSrc, title: imageTitle}];
      modalState.currentIndex = 0;
    }
    
    // Reset modal state
    resetModalState();
    
    // Show modal with loading state
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    modalLoading.style.display = "flex";
    modalImage.style.display = "none";
    modalCaption.style.display = "none";
    
    // Set title
    modalTitle.textContent = imageTitle;
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = "hidden";
    
    // Add navigation buttons if there are multiple images
    addNavigationButtons();
    
    // Load image
    loadModalImage(imageSrc, imageTitle);
    const currentImage = modalState.images[modalState.currentIndex];
    loadModalImage(currentImage.src, currentImage.title);
    
    // Add enhanced event listeners
    addEnhancedEventListeners();
  }, 10); // Small delay to ensure DOM is ready
}

/**
 * Load Modal Image with Error Handling
 */
function loadModalImage(imageSrc, imageTitle) {
  const modalImage = document.getElementById("modal-image");
  const modalTitle = document.getElementById("modal-title");
  const modalCaption = document.getElementById("modal-caption");
  const modalLoading = document.getElementById("modal-loading");
  
  // Enhanced null checking
  if (!modalImage || !modalTitle || !modalCaption || !modalLoading) {
    console.error('Gallery modal elements not found in loadModalImage:', {
      modalImage: !!modalImage,
      modalTitle: !!modalTitle,
      modalCaption: !!modalCaption,
      modalLoading: !!modalLoading
    });
    return;
  }
  
  modalLoading.style.display = "flex";
  modalImage.style.display = "none";
  
  const img = new Image();
  
  img.onload = function() {
    modalImage.src = this.src;
    modalImage.alt = imageTitle;
    modalTitle.textContent = imageTitle;
    modalCaption.textContent = `Gambar ${modalState.currentIndex + 1} dari ${modalState.images.length}`;
    
    modalLoading.style.display = "none";
    modalImage.style.display = "block";
    modalCaption.style.display = "block";
    
    // Update image counter
    updateImageCounter();
    
    // Reset zoom and transform
    resetImageTransform();
  };
  
  img.onerror = function() {
    modalLoading.style.display = "none";
    modalTitle.textContent = "Error Loading Image";
    modalCaption.innerHTML = `
      <div class="text-center text-red-400">
        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>Gagal memuat gambar</p>
        <button onclick="closeImageModal()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Tutup</button>
      </div>
    `;
    modalCaption.style.display = "block";
  };
  
  img.src = imageSrc;
}

/**
 * Reset Modal State
 */
function resetModalState() {
  const modalImage = document.getElementById("modal-image");
  
  // Intelligent default zoom based on screen size
  modalState.zoom = getDefaultGalleryZoom();
  modalState.isFullscreen = false;
  modalState.isDragging = false;
  resetImageTransform();
}

/**
 * Reset Image Transform
 */
function resetImageTransform() {
  const modalImage = document.getElementById("modal-image");
  if (modalImage) {
    const defaultZoom = getDefaultGalleryZoom();
    modalImage.style.transform = `scale(${defaultZoom}) translate(0, 0)`;
    modalState.zoom = defaultZoom;
  }
}

/**
 * Add Navigation Buttons
 */
function addNavigationButtons() {
  const modal = document.getElementById("image-modal");
  const prevBtn = document.getElementById("modal-prev");
  const nextBtn = document.getElementById("modal-next");
  
  if (modalState.images.length > 1) {
    if (prevBtn) prevBtn.classList.remove("hidden");
    if (nextBtn) nextBtn.classList.remove("hidden");
    
    // Add click listeners if not already added
    if (prevBtn && !prevBtn.hasAttribute('data-listener-added')) {
      prevBtn.addEventListener('click', () => navigateImage(-1));
      prevBtn.setAttribute('data-listener-added', 'true');
    }
    
    if (nextBtn && !nextBtn.hasAttribute('data-listener-added')) {
      nextBtn.addEventListener('click', () => navigateImage(1));
      nextBtn.setAttribute('data-listener-added', 'true');
    }
  } else {
    if (prevBtn) prevBtn.classList.add("hidden");
    if (nextBtn) nextBtn.classList.add("hidden");
  }
}

/**
 * Update Image Counter
 */
function updateImageCounter() {
  const counter = document.getElementById("modal-counter");
  if (counter && modalState.images.length > 1) {
    counter.textContent = `${modalState.currentIndex + 1} / ${modalState.images.length}`;
  }
}

/**
 * Navigate Images
 */
function navigateImage(direction) {
  if (modalState.images.length <= 1) return;
  
  modalState.currentIndex += direction;
  
  if (modalState.currentIndex >= modalState.images.length) {
    modalState.currentIndex = 0;
  } else if (modalState.currentIndex < 0) {
    modalState.currentIndex = modalState.images.length - 1;
  }
  
  const currentImage = modalState.images[modalState.currentIndex];
  loadModalImage(currentImage.src, currentImage.title);
}

/**
 * Get Default Gallery Zoom based on screen size
 */
function getDefaultGalleryZoom() {
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
 * Zoom Image
 */
function zoomImage(direction) {
  const modalImage = document.getElementById("modal-image");
  if (!modalImage) return;
  
  modalState.zoom += direction * 0.25;
  modalState.zoom = Math.max(0.5, Math.min(modalState.zoom, 3));
  
  modalImage.style.transform = `scale(${modalState.zoom})`;
}

/**
 * Toggle Fullscreen
 */
function toggleFullscreen() {
  const modal = document.getElementById("image-modal");
  
  if (!modalState.isFullscreen) {
    if (modal.requestFullscreen) {
      modal.requestFullscreen();
    } else if (modal.webkitRequestFullscreen) {
      modal.webkitRequestFullscreen();
    } else if (modal.msRequestFullscreen) {
      modal.msRequestFullscreen();
    }
    modalState.isFullscreen = true;
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
    modalState.isFullscreen = false;
  }
}

/**
 * Add Enhanced Event Listeners
 */
function addEnhancedEventListeners() {
  const modalImage = document.getElementById("modal-image");
  
  if (modalImage && !modalImage.hasAttribute('data-listeners-added')) {
    // Double click to zoom
    modalImage.addEventListener('dblclick', () => {
      if (modalState.zoom === 1) {
        zoomImage(1);
      } else {
        resetImageTransform();
      }
    });
    
    // Mouse wheel zoom
    modalImage.addEventListener('wheel', (e) => {
      e.preventDefault();
      zoomImage(e.deltaY > 0 ? -1 : 1);
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
        modalState.zoom = Math.max(0.5, Math.min(modalState.zoom * scale, 3));
        modalImage.style.transform = `scale(${modalState.zoom})`;
        touchStartDistance = touchDistance;
      }
    });
    
    modalImage.setAttribute('data-listeners-added', 'true');
  }
}

/**
 * Close Image Modal
 */
function closeImageModal() {
  const modal = document.getElementById("image-modal");
  
  if (modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    
    // Restore body scroll
    document.body.style.overflow = "";
    
    // Reset modal state
    resetModalState();
    
    // Exit fullscreen if active
    if (modalState.isFullscreen) {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
      modalState.isFullscreen = false;
    }
  }
}

/**
 * Initialize Gallery Collections
 */
function initializeGalleryCollections() {
  // Group gallery items by their parent gallery container
  const galleryContainers = document.querySelectorAll(".mtq-gallery-grid, .mtq-gallery-slider, .mtq-gallery-masonry, #gallery-grid, .gallery-grid-container");
  
  galleryContainers.forEach(container => {
    const galleryItems = container.querySelectorAll(".image-gallery-item, .gallery-item img, .gallery-item [data-image-src], .gallery-thumbnail");
    
    if (galleryItems.length > 0) {
      // Create collection of images for this gallery
      const galleryImages = Array.from(galleryItems).map(item => {
        // Handle different data attribute formats
        let src = item.getAttribute("data-image-src") || 
                 item.getAttribute("data-src") || 
                 item.src || 
                 item.getAttribute("href");
        
        let title = item.getAttribute("data-image-title") || 
                   item.getAttribute("data-title") || 
                   item.alt || 
                   item.closest('.gallery-item')?.getAttribute('data-title') || "";
        
        return { src, title };
      }).filter(img => img.src); // Only include items with valid src
      
      // Add click listeners with gallery collection support
      galleryItems.forEach((item, index) => {
        item.addEventListener("click", function(e) {
          // Don't prevent default for regular links unless it's a gallery thumbnail
          if (!this.classList.contains('gallery-thumbnail') && !this.hasAttribute('data-image-src')) {
            return; // Let normal navigation happen
          }
          
          e.preventDefault();
          e.stopPropagation();
          
          let imageSrc = this.getAttribute("data-image-src") || 
                        this.getAttribute("data-src") || 
                        this.src || 
                        this.getAttribute("href");
          
          let imageTitle = this.getAttribute("data-image-title") || 
                          this.getAttribute("data-title") || 
                          this.alt || 
                          this.closest('.gallery-item')?.getAttribute('data-title') || "";
          
          if (imageSrc) {
            // Find the current image index in the gallery
            const currentIndex = galleryImages.findIndex(img => img.src === imageSrc);
            if (currentIndex !== -1) {
              modalState.currentIndex = currentIndex;
            }
            
            openImageModal(imageSrc, imageTitle, galleryImages);
          }
        });
      });
    }
  });
  
  // Handle standalone gallery items (not in collections)
  const standaloneItems = document.querySelectorAll(".image-gallery-item, .gallery-thumbnail, [data-image-src]");
  standaloneItems.forEach(item => {
    const parentGallery = item.closest(".mtq-gallery-grid, .mtq-gallery-slider, .mtq-gallery-masonry, #gallery-grid, .gallery-grid-container");
    
    // Only add listener if not already handled by gallery collection
    if (!parentGallery) {
      item.addEventListener("click", function(e) {
        // Don't prevent default for regular links unless it's a gallery thumbnail
        if (!this.classList.contains('gallery-thumbnail') && !this.hasAttribute('data-image-src')) {
          return; // Let normal navigation happen
        }
        
        e.preventDefault();
        e.stopPropagation();
        
        let imageSrc = this.getAttribute("data-image-src") || 
                      this.getAttribute("data-src") || 
                      this.src || 
                      this.getAttribute("href");
        
        let imageTitle = this.getAttribute("data-image-title") || 
                        this.getAttribute("data-title") || 
                        this.alt || "";
        
        if (imageSrc) {
          openImageModal(imageSrc, imageTitle);
        }
      });
    }
  });
}

/**
 * Initialize Gallery Module
 */
function initializeGallery() {
  // Modal close functionality
  const modal = document.getElementById("image-modal");
  const closeBtn = document.getElementById("modal-close");
  
  // Modal close on background click
  if (modal) {
    modal.addEventListener("click", function(e) {
      if (e.target === modal) {
        closeImageModal();
      }
    });
  }
  
  // Modal close button
  if (closeBtn) {
    closeBtn.addEventListener("click", closeImageModal);
  }
  
  // Zoom controls
  const zoomInBtn = document.getElementById("modal-zoom-in");
  const zoomOutBtn = document.getElementById("modal-zoom-out");
  const zoomResetBtn = document.getElementById("modal-zoom-reset");
  
  if (zoomInBtn) {
    zoomInBtn.addEventListener("click", () => zoomImage(1));
  }
  
  if (zoomOutBtn) {
    zoomOutBtn.addEventListener("click", () => zoomImage(-1));
  }
  
  if (zoomResetBtn) {
    zoomResetBtn.addEventListener("click", resetImageTransform);
  }
  
  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (modal && !modal.classList.contains('hidden')) {
      switch(e.key) {
        case 'Escape':
          closeImageModal();
          break;
        case 'ArrowLeft':
          navigateImage(-1);
          break;
        case 'ArrowRight':
          navigateImage(1);
          break;
        case ' ': // Spacebar for zoom
          e.preventDefault();
          if (modalState.zoom === 1) {
            zoomImage(1);
          } else {
            resetImageTransform();
          }
          break;
      }
    }
  });
  
  // Initialize gallery collections
  initializeGalleryCollections();
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeGallery);
} else {
  initializeGallery();
}

// Export functions for global access
window.openImageModal = openImageModal;
window.closeImageModal = closeImageModal;
window.navigateImage = navigateImage;
window.initializeGallery = initializeGallery;
