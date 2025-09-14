/**
 * MTQ Aceh XXXVII Website JavaScript
 * Main application file for general website functionality (non-gallery)
 * Gallery functionality is handled in gallery.js
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 * @author @saipulbahri-it
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
  { threshold: 0.25 },
);

imgZooms.forEach((el) => imgObserver.observe(el));

// Section animation observer
const sectionElements = document.querySelectorAll(".section-animate");

if (sectionElements.length > 0) {
  const sectionObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          // Add staggered animation delay
          setTimeout(() => {
            entry.target.classList.add("visible");
          }, index * 150);
          sectionObserver.unobserve(entry.target);
        }
      });
    },
    { 
      threshold: 0.1,
      rootMargin: "0px 0px -10% 0px"
    },
  );

  sectionElements.forEach((el) => sectionObserver.observe(el));
}

// Contact Form Enhancement
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

// YouTube Live Stream Handler
function initializeYouTubeLive() {
  const liveContainer = document.getElementById("youtube-live-container");
  const liveIframe = document.getElementById("youtube-live-iframe");
  
  if (liveContainer && liveIframe) {
    // Check if live stream is active
    const channelId = "YOUR_CHANNEL_ID"; // Replace with actual channel ID
    const apiKey = "YOUR_API_KEY"; // Replace with actual API key
    
    // This would require YouTube API integration
    // For now, just show the iframe
    liveContainer.style.display = "block";
  }
}

// Initialize YouTube Live on page load
document.addEventListener("DOMContentLoaded", initializeYouTubeLive);

// Countdown Timer (if exists on page)
function initializeCountdown() {
  const countdownElement = document.getElementById("countdown-timer");
  
  if (countdownElement) {
    const targetDate = countdownElement.getAttribute("data-target-date");
    
    if (targetDate) {
      const countdown = setInterval(function() {
        const now = new Date().getTime();
        const target = new Date(targetDate).getTime();
        const distance = target - now;
        
        if (distance > 0) {
          const days = Math.floor(distance / (1000 * 60 * 60 * 24));
          const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          const seconds = Math.floor((distance % (1000 * 60)) / 1000);
          
          countdownElement.innerHTML = `
            <div class="flex space-x-4 text-center">
              <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <div class="text-2xl font-bold">${days}</div>
                <div class="text-sm">Hari</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <div class="text-2xl font-bold">${hours}</div>
                <div class="text-sm">Jam</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <div class="text-2xl font-bold">${minutes}</div>
                <div class="text-sm">Menit</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <div class="text-2xl font-bold">${seconds}</div>
                <div class="text-sm">Detik</div>
              </div>
            </div>
          `;
        } else {
          countdownElement.innerHTML = "<h2 class='text-2xl font-bold'>Event Telah Dimulai!</h2>";
          clearInterval(countdown);
        }
      }, 1000);
    }
  }
}

// Initialize countdown on page load
document.addEventListener("DOMContentLoaded", initializeCountdown);

// Mobile Menu Toggle
function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobile-menu");
  if (mobileMenu) {
    mobileMenu.classList.toggle("hidden");
  }
}

// Search functionality
function initializeSearch() {
  const searchInput = document.getElementById("search-input");
  const searchResults = document.getElementById("search-results");
  
  if (searchInput && searchResults) {
    searchInput.addEventListener("input", function() {
      const query = this.value.trim();
      
      if (query.length > 2) {
        // Perform search - this would integrate with WordPress search
        performSearch(query);
      } else {
        searchResults.innerHTML = "";
        searchResults.classList.add("hidden");
      }
    });
  }
}

function performSearch(query) {
  // This would integrate with WordPress REST API for search
  // For now, just show a placeholder
  const searchResults = document.getElementById("search-results");
  
  if (searchResults) {
    searchResults.innerHTML = `
      <div class="p-4 bg-white rounded-lg shadow-lg">
        <p class="text-gray-600">Mencari: "${query}"...</p>
      </div>
    `;
    searchResults.classList.remove("hidden");
  }
}

// Initialize search on page load
document.addEventListener("DOMContentLoaded", initializeSearch);

// Social Media Share Functions
function shareToFacebook() {
  const url = encodeURIComponent(window.location.href);
  const title = encodeURIComponent(document.title);
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank');
}

function shareToTwitter() {
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(document.title);
  window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareToTelegram() {
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(document.title);
  window.open(`https://t.me/share/url?url=${url}&text=${text}`, '_blank');
}

// Lazy loading for images
function initializeLazyLoading() {
  const lazyImages = document.querySelectorAll('img[data-src]');
  
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.remove('lazy');
        observer.unobserve(img);
      }
    });
  });
  
  lazyImages.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading on page load
document.addEventListener("DOMContentLoaded", initializeLazyLoading);

// Smooth scrolling for anchor links
document.addEventListener("DOMContentLoaded", function() {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  
  anchorLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);
      
      if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});

// Back to top button
function initializeBackToTop() {
  const backToTopBtn = document.getElementById('back-to-top');
  
  if (backToTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.remove('hidden');
      } else {
        backToTopBtn.classList.add('hidden');
      }
    });
    
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
}

// Initialize back to top on page load
document.addEventListener("DOMContentLoaded", initializeBackToTop);

// Form validation and enhancement
function initializeForms() {
  const forms = document.querySelectorAll('form[data-validate]');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const isValid = validateForm(this);
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  });
}

function validateForm(form) {
  const requiredFields = form.querySelectorAll('[required]');
  let isValid = true;
  
  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.classList.add('border-red-500');
      isValid = false;
    } else {
      field.classList.remove('border-red-500');
    }
  });
  
  return isValid;
}

// Initialize forms on page load
document.addEventListener("DOMContentLoaded", initializeForms);

// Print functionality
function printPage() {
  window.print();
}

// Copy URL to clipboard with feedback
function copyCurrentURL() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    showNotification('URL berhasil disalin ke clipboard!');
  }).catch(() => {
    showNotification('Gagal menyalin URL', 'error');
  });
}

// Show notification
function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.className = `
    fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm
    ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} text-white
    transform translate-x-full transition-transform duration-300
  `;
  notification.innerHTML = `
    <div class="flex items-center">
      <span class="flex-1">${message}</span>
      <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
  `;
  
  document.body.appendChild(notification);
  
  // Animate in
  setTimeout(() => {
    notification.classList.remove('translate-x-full');
  }, 100);
  
  // Auto remove after 5 seconds
  setTimeout(() => {
    notification.classList.add('translate-x-full');
    setTimeout(() => {
      if (notification.parentElement) {
        notification.remove();
      }
    }, 300);
  }, 5000);
}

// Enhanced loading states
function showLoading(element) {
  if (element) {
    element.classList.add('opacity-50', 'pointer-events-none');
    element.innerHTML += '<div class="loading-spinner"></div>';
  }
}

function hideLoading(element) {
  if (element) {
    element.classList.remove('opacity-50', 'pointer-events-none');
    const spinner = element.querySelector('.loading-spinner');
    if (spinner) {
      spinner.remove();
    }
  }
}

// Performance monitoring
function initializePerformanceMonitoring() {
  if ('performance' in window) {
    window.addEventListener('load', () => {
      setTimeout(() => {
        const perfData = performance.getEntriesByType('navigation')[0];
        const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
        
        if (loadTime > 3000) {
          console.warn('Page load time is slow:', loadTime + 'ms');
        }
      }, 0);
    });
  }
}

// Initialize performance monitoring
initializePerformanceMonitoring();

// Error handling and debugging
function logError(error, context = '') {
  console.error(`[MTQ Error] ${context}:`, error);
}

// Initialize all main application features
document.addEventListener("DOMContentLoaded", function() {
  try {
    // Initialize core features
    initializeYouTubeLive();
    initializeCountdown();
    initializeSearch();
    initializeLazyLoading();
    initializeBackToTop();
    initializeForms();
    
    console.log('MTQ Website initialized successfully');
  } catch (error) {
    logError(error, 'Initialization');
  }
});
