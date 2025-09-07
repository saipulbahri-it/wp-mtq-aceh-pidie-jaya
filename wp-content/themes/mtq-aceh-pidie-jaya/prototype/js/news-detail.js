// News detail functionality
// Developed by @saipulbahri-it

// Get news ID from URL
function getNewsIdFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  return parseInt(urlParams.get('id'));
}

// Get news by ID
function getNewsById(id) {
  return window.newsData ? window.newsData.find(news => news.id === id) : null;
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  const newsId = getNewsIdFromUrl();
  
  if (!newsId) {
    showNotFound();
    return;
  }
  
  // Wait for newsData to be available
  if (window.newsData) {
    loadNewsDetail(newsId);
  } else {
    // If newsData is not loaded yet, wait for it
    const checkData = setInterval(() => {
      if (window.newsData) {
        clearInterval(checkData);
        loadNewsDetail(newsId);
      }
    }, 100);
  }
  
  setupShareButtons();
});

// Load news detail
function loadNewsDetail(newsId) {
  const news = getNewsById(newsId);
  
  if (!news) {
    showNotFound();
    return;
  }
  
  // Update page title
  document.title = `${news.title} - MTQ ACEH XXXVII Pidie Jaya 2025`;
  document.getElementById('page-title').textContent = `${news.title} - MTQ ACEH XXXVII`;
  
  // Update breadcrumb
  const breadcrumbTitle = document.getElementById('breadcrumb-title');
  if (breadcrumbTitle) {
    breadcrumbTitle.textContent = news.title.length > 50 ? 
      news.title.substring(0, 50) + '...' : news.title;
  }
  
  // Update article content
  updateArticleContent(news);
  
  // Update views (simulate)
  incrementViews(news.id);
  
  // Load related news
  loadRelatedNews(news);
  
  // Update meta tags for SEO and social sharing
  updateMetaTags(news);
}

// Update article content
function updateArticleContent(news) {
  // Category
  const categoryElement = document.getElementById('article-category');
  if (categoryElement) {
    categoryElement.textContent = window.getCategoryName ? 
      window.getCategoryName(news.category) : news.category;
    categoryElement.className = `inline-block px-3 py-1 text-sm font-medium rounded-full ${getCategoryColor(news.category)}`;
  }
  
  // Title
  const titleElement = document.getElementById('article-title');
  if (titleElement) {
    titleElement.textContent = news.title;
  }
  
  // Date
  const dateElement = document.getElementById('article-date');
  if (dateElement) {
    dateElement.textContent = window.formatDate ? 
      window.formatDate(news.date) : news.date;
  }
  
  // Author
  const authorElement = document.getElementById('article-author');
  if (authorElement) {
    authorElement.textContent = news.author;
  }
  
  // Views
  const viewsElement = document.getElementById('article-views');
  if (viewsElement) {
    viewsElement.textContent = news.views.toLocaleString('id-ID');
  }
  
  // Featured image
  const imageContainer = document.getElementById('article-image-container');
  if (imageContainer && news.image) {
    imageContainer.innerHTML = `
      <div class="glass-card overflow-hidden">
        <img 
          src="${news.image}" 
          alt="${news.title}"
          class="w-full h-64 md:h-96 object-cover"
        />
      </div>
    `;
  }
  
  // Content
  const contentElement = document.getElementById('article-content');
  if (contentElement) {
    contentElement.innerHTML = news.content;
  }
}

// Get category color
function getCategoryColor(category) {
  const categoryColors = {
    'persiapan': 'bg-blue-100 text-blue-800',
    'peserta': 'bg-green-100 text-green-800',
    'lomba': 'bg-yellow-100 text-yellow-800',
    'acara': 'bg-red-100 text-red-800',
    'pengumuman': 'bg-purple-100 text-purple-800'
  };
  return categoryColors[category] || 'bg-gray-100 text-gray-800';
}

// Increment views
function incrementViews(newsId) {
  if (window.newsData) {
    const news = window.newsData.find(n => n.id === newsId);
    if (news) {
      news.views++;
      // Update display
      const viewsElement = document.getElementById('article-views');
      if (viewsElement) {
        viewsElement.textContent = news.views.toLocaleString('id-ID');
      }
    }
  }
}

// Load related news
function loadRelatedNews(currentNews) {
  const relatedContainer = document.getElementById('related-news');
  if (!relatedContainer || !window.newsData) return;
  
  // Get related news (same category, excluding current)
  const relatedNews = window.newsData
    .filter(news => news.id !== currentNews.id && news.category === currentNews.category)
    .slice(0, 3);
  
  // If not enough from same category, add from other categories
  if (relatedNews.length < 3) {
    const additional = window.newsData
      .filter(news => news.id !== currentNews.id && news.category !== currentNews.category)
      .slice(0, 3 - relatedNews.length);
    relatedNews.push(...additional);
  }
  
  if (relatedNews.length === 0) {
    relatedContainer.innerHTML = '<p class="text-gray-500">Tidak ada berita terkait.</p>';
    return;
  }
  
  relatedContainer.innerHTML = relatedNews.map(news => createRelatedNewsCard(news)).join('');
}

// Create related news card
function createRelatedNewsCard(news) {
  return `
    <article class="glass-card-sm group hover:shadow-lg transition-all duration-300">
      <div class="relative overflow-hidden rounded-t-lg">
        <img 
          src="${news.image}" 
          alt="${news.title}"
          class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300"
          loading="lazy"
        />
      </div>
      
      <div class="p-4">
        <h4 class="text-sm font-semibold text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
          <a href="news-detail.html?id=${news.id}" class="hover:underline">
            ${news.title}
          </a>
        </h4>
        
        <p class="text-xs text-slate-600 mb-3 line-clamp-2">
          ${news.excerpt}
        </p>
        
        <div class="flex items-center justify-between text-xs text-slate-500">
          <span>${window.formatDate ? window.formatDate(news.date) : news.date}</span>
          <span>${news.views} views</span>
        </div>
      </div>
    </article>
  `;
}

// Setup share buttons
function setupShareButtons() {
  const shareButtons = {
    'share-facebook': shareFacebook,
    'share-whatsapp': shareWhatsApp,
    'share-copy': copyLink
  };
  
  Object.entries(shareButtons).forEach(([id, handler]) => {
    const button = document.getElementById(id);
    if (button) {
      button.addEventListener('click', handler);
    }
  });
}

// Share to Facebook
function shareFacebook() {
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(document.getElementById('article-title').textContent);
  const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`;
  window.open(facebookUrl, '_blank', 'width=600,height=400');
}

// Share to WhatsApp
function shareWhatsApp() {
  const url = window.location.href;
  const title = document.getElementById('article-title').textContent;
  const text = `*${title}*\n\nBaca selengkapnya: ${url}\n\n#MTQAcehXXXVII #PidieJaya2025`;
  const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
  window.open(whatsappUrl, '_blank');
}

// Copy link
function copyLink() {
  const button = document.getElementById('share-copy');
  const originalText = button.innerHTML;
  
  navigator.clipboard.writeText(window.location.href).then(() => {
    button.innerHTML = `
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span class="hidden sm:inline">Tersalin!</span>
    `;
    button.classList.add('bg-green-600', 'hover:bg-green-700');
    button.classList.remove('bg-slate-600', 'hover:bg-slate-700');
    
    setTimeout(() => {
      button.innerHTML = originalText;
      button.classList.remove('bg-green-600', 'hover:bg-green-700');
      button.classList.add('bg-slate-600', 'hover:bg-slate-700');
    }, 2000);
  }).catch(() => {
    // Fallback for older browsers
    const textArea = document.createElement('textarea');
    textArea.value = window.location.href;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);
    
    button.innerHTML = `
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span class="hidden sm:inline">Tersalin!</span>
    `;
  });
}

// Update meta tags for SEO and social sharing
function updateMetaTags(news) {
  // Update or create meta tags
  updateMetaTag('description', news.excerpt);
  updateMetaTag('keywords', `MTQ Aceh, ${news.category}, Pidie Jaya, Al-Qur'an`);
  
  // Open Graph tags
  updateMetaTag('og:title', news.title, 'property');
  updateMetaTag('og:description', news.excerpt, 'property');
  updateMetaTag('og:image', news.image, 'property');
  updateMetaTag('og:url', window.location.href, 'property');
  updateMetaTag('og:type', 'article', 'property');
  
  // Twitter Card tags
  updateMetaTag('twitter:card', 'summary_large_image');
  updateMetaTag('twitter:title', news.title);
  updateMetaTag('twitter:description', news.excerpt);
  updateMetaTag('twitter:image', news.image);
}

// Update meta tag helper
function updateMetaTag(name, content, attribute = 'name') {
  let meta = document.querySelector(`meta[${attribute}="${name}"]`);
  if (!meta) {
    meta = document.createElement('meta');
    meta.setAttribute(attribute, name);
    document.head.appendChild(meta);
  }
  meta.setAttribute('content', content);
}

// Show not found message
function showNotFound() {
  document.title = 'Berita Tidak Ditemukan - MTQ ACEH XXXVII';
  
  const main = document.querySelector('main');
  if (main) {
    main.innerHTML = `
      <div class="container mx-auto px-6 py-16 text-center">
        <div class="glass-card p-12 max-w-2xl mx-auto">
          <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
          </svg>
          <h1 class="text-3xl font-bold text-slate-800 mb-4">Berita Tidak Ditemukan</h1>
          <p class="text-slate-600 mb-8">
            Maaf, berita yang Anda cari tidak ditemukan atau mungkin telah dihapus.
          </p>
          <div class="space-x-4">
            <a 
              href="news.html" 
              class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4 4m4-4l-4-4"></path>
              </svg>
              <span>Kembali ke Berita</span>
            </a>
            <a 
              href="index.html" 
              class="inline-flex items-center space-x-2 px-6 py-3 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              <span>Beranda</span>
            </a>
          </div>
        </div>
      </div>
    `;
  }
}