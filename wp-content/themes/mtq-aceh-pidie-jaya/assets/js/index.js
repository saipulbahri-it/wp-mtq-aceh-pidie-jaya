/**
 * MTQ Aceh XXXVII Website JavaScript
 * Created by @saipulbahri-it
 */


// Header scroll effect
const header = document.getElementById("main-header");
let scrolled = false;

window.addEventListener("scroll", function () {
  const isScrolled = window.scrollY > 50;

  if (isScrolled && !scrolled) {
    header.classList.add("header-scrolled");
    scrolled = true;
  } else if (!isScrolled && scrolled) {
    header.classList.remove("header-scrolled");
    scrolled = false;
  }
});

// Mobile menu toggle
const mobileMenuBtn = document.getElementById("mobile-menu-btn");
const mobileMenu = document.getElementById("mobile-menu");

mobileMenuBtn.addEventListener("click", function () {
  mobileMenu.classList.toggle("hidden");

  const svg = mobileMenuBtn.querySelector("svg");
  const path = svg.querySelector("path");

  if (mobileMenu.classList.contains("hidden")) {
    path.setAttribute("d", "M4 6h16M4 12h16M4 18h16");
  } else {
    path.setAttribute("d", "M6 18L18 6M6 6l12 12");
  }
});

// Close mobile menu when clicking on links
const mobileLinks = mobileMenu.querySelectorAll("a");
mobileLinks.forEach((link) => {
  link.addEventListener("click", function () {
    mobileMenu.classList.add("hidden");
    const svg = mobileMenuBtn.querySelector("svg");
    const path = svg.querySelector("path");
    path.setAttribute("d", "M4 6h16M4 12h16M4 18h16");
  });
});

// Fade in animation observer
const fadeElements = document.querySelectorAll(".fade-in");
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        entry.target.style.animationDelay = `${
          i * 0.08 + Math.random() * 0.08
        }s`;
        entry.target.classList.add("fade-in-activated");
        entry.target.classList.remove("fade-in");
        observer.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.15 },
);

fadeElements.forEach((el) => observer.observe(el));

// Gambar animasi zoom-in
const imgZooms = document.querySelectorAll(".img-zoom-in");
const imgObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        imgObserver.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.2 },
);

imgZooms.forEach((img) => imgObserver.observe(img));

// Section scroll animation
document.querySelectorAll(".section-animate").forEach((section) => {
  section.classList.remove("visible");
});

const sectionObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        sectionObserver.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.18 },
);

document.querySelectorAll(".section-animate").forEach((section) => {
  sectionObserver.observe(section);
});

// Overlay video logic
const openOverlayBtn = document.getElementById("open-video-overlay");
const closeOverlayBtn = document.getElementById("close-video-overlay");
const videoOverlay = document.getElementById("video-overlay");

if (openOverlayBtn && closeOverlayBtn && videoOverlay) {
  openOverlayBtn.addEventListener("click", () => {
    videoOverlay.classList.remove("hidden");
    document.body.style.overflow = "hidden";
  });
  closeOverlayBtn.addEventListener("click", () => {
    videoOverlay.classList.add("hidden");
    document.body.style.overflow = "";
    // Stop video playback by resetting src
    const iframe = videoOverlay.querySelector("iframe");
    iframe.src = iframe.src;
  });
  // Optional: close overlay on ESC key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !videoOverlay.classList.contains("hidden")) {
      videoOverlay.classList.add("hidden");
      document.body.style.overflow = "";
      const iframe = videoOverlay.querySelector("iframe");
      iframe.src = iframe.src;
    }
  });
}

// Share Modal
function openShareModal() {
  document.getElementById("share-modal").classList.add("open");
}
function closeShareModal() {
  document.getElementById("share-modal").classList.remove("open");
}
const shareBtn = document.getElementById("share-btn");
if (shareBtn) shareBtn.onclick = openShareModal;

const shareBtnMobile = document.getElementById("share-btn-mobile");
if (shareBtnMobile) shareBtnMobile.onclick = openShareModal;

const closeShare = document.getElementById("close-share");
if (closeShare) closeShare.onclick = closeShareModal;

// Share Functions
function shareToFacebook() {
  const url = location.href;
  window.open(
    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
    "_blank",
  );
}
function shareToTwitter() {
  const url = location.href;
  window.open(
    `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}`,
    "_blank",
  );
}
function shareToWhatsApp() {
  const url = location.href;
  window.open(
    `https://api.whatsapp.com/send?text=${encodeURIComponent(url)}`,
    "_blank",
  );
}
function copyToClipboard() {
  navigator.clipboard.writeText(location.href).then(() => {
    alert("Link copied to clipboard!");
  });
}

// Image Preview Modal
function openImageModal(imageSrc, imageTitle) {
  const modal = document.getElementById("image-modal");
  const modalImage = document.getElementById("modal-image");
  const modalTitle = document.getElementById("modal-title");
  const modalCaption = document.getElementById("modal-caption");
  const modalLoading = document.getElementById("modal-loading");
  
  if (modal && modalImage && modalTitle && modalCaption && modalLoading) {
    // Show modal with loading state
    modal.classList.add("open");
    modalLoading.style.display = "flex";
    modalImage.style.display = "none";
    modalCaption.style.display = "none";
    
    // Set title
    modalTitle.textContent = imageTitle;
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = "hidden";
    
    // Load image
    const img = new Image();
    img.onload = function() {
      modalImage.src = imageSrc;
      modalImage.alt = imageTitle;
      
      // Hide loading, show image and caption
      modalLoading.style.display = "none";
      modalImage.style.display = "block";
      modalCaption.style.display = "block";
    };
    
    img.onerror = function() {
      modalLoading.innerHTML = `
        <div class="text-center">
          <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <p class="text-white text-sm">Gagal memuat gambar</p>
          <button onclick="closeImageModal()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Tutup</button>
        </div>
      `;
    };
    
    img.src = imageSrc;
  }
}

function closeImageModal() {
  const modal = document.getElementById("image-modal");
  
  if (modal) {
    modal.classList.remove("open");
    
    // Restore body scroll
    document.body.style.overflow = "";
  }
}

// Close modal when pressing Escape key
document.addEventListener("keydown", function(event) {
  if (event.key === "Escape") {
    closeImageModal();
  }
});

// Ensure modal close button and overlay work
document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("image-modal");
  const overlay = document.querySelector(".image-modal-overlay");
  const closeBtn = document.querySelector(".image-modal-close");
  
  if (overlay) {
    overlay.addEventListener("click", closeImageModal);
  }
  
  if (closeBtn) {
    closeBtn.addEventListener("click", closeImageModal);
  }
  
  // Add click event listeners to all image gallery items
  const galleryItems = document.querySelectorAll(".image-gallery-item");
  galleryItems.forEach(function(item) {
    item.addEventListener("click", function() {
      const imageSrc = this.getAttribute("data-image-src");
      const imageTitle = this.getAttribute("data-image-title");
      
      if (imageSrc && imageTitle) {
        openImageModal(imageSrc, imageTitle);
      }
    });
  });
});
