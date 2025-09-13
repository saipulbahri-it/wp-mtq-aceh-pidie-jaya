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
