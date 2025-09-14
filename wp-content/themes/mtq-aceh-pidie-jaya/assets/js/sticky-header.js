/**
 * Enhanced Sticky Header JavaScript
 * Handles scroll behavior, animations, and interactions for the sticky header
 */

document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('main-header');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    let lastScrollTop = 0;
    let isScrolling = false;
    
    // Admin bar height calculation (robust)
    function getAdminBarHeight() {
        const adminBar = document.getElementById('wpadminbar');
        const hasAdminFlag = document.body.classList.contains('admin-bar') ||
            document.documentElement.classList.contains('admin-bar') ||
            document.documentElement.classList.contains('wp-toolbar');
        if (adminBar && hasAdminFlag) {
            const rectH = Math.round(adminBar.getBoundingClientRect().height || 0);
            const offH = Math.round(adminBar.offsetHeight || 0);
            const h = rectH || offH;
            // Fallback to known WP heights
            return h > 0 ? h : (window.innerWidth > 782 ? 32 : 46);
        }
        return 0;
    }
    
    // Update header position using CSS custom properties
    function updateHeaderPosition() {
        const adminBarHeight = getAdminBarHeight();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
        const isMobile = window.innerWidth <= 782;
        // Expose CSS vars for use in CSS
        document.documentElement.style.setProperty('--admin-bar-height', adminBarHeight + 'px');
        document.documentElement.style.setProperty('--header-height', (header?.offsetHeight || 0) + 'px');

        // On mobile while scrolling down, keep header at top: 0
        if (isMobile && scrollTop > 0) {
            header.style.setProperty('top', '0px', 'important');
            if (adminBarHeight > 0) header.classList.add('with-admin-bar');
        } else if (document.body.classList.contains('admin-bar') || adminBarHeight > 0) {
            // At top of page (or desktop), respect admin bar height
            header.style.setProperty('top', adminBarHeight + 'px', 'important');
            header.classList.add('with-admin-bar');
        } else {
            header.style.setProperty('top', '0px', 'important');
            header.classList.remove('with-admin-bar');
        }

        // Force repaint
        header.style.transform = 'translateZ(0)';
    }
    
    // Check admin bar status more reliably
    function checkAdminBar() {
        const adminBar = document.getElementById('wpadminbar');
        const hasAdminBar = adminBar && adminBar.offsetHeight > 0;
        
        if (hasAdminBar && !document.body.classList.contains('admin-bar')) {
            document.body.classList.add('admin-bar');
        }
        
        return hasAdminBar;
    }
    
    // Initialize header position
    checkAdminBar();
    updateHeaderPosition();
    
    // Observer for admin bar changes
    function observeAdminBar() {
        const adminBar = document.getElementById('wpadminbar');
        if (adminBar) {
            const observer = new MutationObserver(function() {
                setTimeout(function() {
                    checkAdminBar();
                    updateHeaderPosition();
                }, 100);
            });
            
            observer.observe(adminBar, {
                attributes: true,
                attributeFilter: ['style', 'class'],
                childList: true,
                subtree: true
            });
        }
    }
    
    // Start observing after a short delay to ensure DOM is ready
    setTimeout(observeAdminBar, 500);
    
    // Also check periodically for admin bar changes (fallback)
    setInterval(function() {
        const currentAdminBarState = checkAdminBar();
        updateHeaderPosition();
    }, 2000);
    
    // Update on window resize with debouncing
    let headerResizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(headerResizeTimeout);
        headerResizeTimeout = setTimeout(function() {
            checkAdminBar();
            updateHeaderPosition();
        }, 150);
    });
    
    // Enhanced scroll behavior
    function handleScroll() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Ensure header positioning is correct during scroll
                updateHeaderPosition();
                
                // Add scrolled class when scrolling down
                if (scrollTop > 20) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                // Optional: Hide header when scrolling down fast, show when scrolling up
                // Uncomment the following lines if you want this behavior:
                /*
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    header.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    header.style.transform = 'translateY(0)';
                }
                */
                
                lastScrollTop = scrollTop;
                isScrolling = false;
            });
        }
        isScrolling = true;
    }
    
    // Throttled scroll event listener
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(handleScroll, 10);
    });
    
    // Mobile menu toggle
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isOpen = !mobileMenu.classList.contains('hidden');
            
            if (isOpen) {
                // Close menu
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                mobileMenuBtn.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            } else {
                // Open menu
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                mobileMenuBtn.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
            }
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            if (!header.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                mobileMenuBtn.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            }
        }
    });
    
    // Close mobile menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            mobileMenuBtn.focus();
        }
    });
    
    // Active navigation link highlighting
    function setActiveNavLink() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            
            // Check if link matches current page or hash
            const linkHref = link.getAttribute('href');
            if (linkHref) {
                if (linkHref === currentPath || 
                    linkHref === window.location.pathname + currentHash ||
                    (currentHash && linkHref.includes(currentHash))) {
                    link.classList.add('active');
                }
            }
        });
    }
    
    // Set active link on page load
    setActiveNavLink();
    
    // Update active link on hash change
    window.addEventListener('hashchange', setActiveNavLink);
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip if it's just "#" or empty
            if (href === '#' || href === '') return;
            
            e.preventDefault();
            
            const target = document.querySelector(href);
            if (target) {
                const headerHeight = header.offsetHeight;
                const adminBarHeight = getAdminBarHeight();
                const targetPosition = target.offsetTop - headerHeight - adminBarHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL hash after smooth scroll
                setTimeout(() => {
                    history.pushState(null, null, href);
                    setActiveNavLink();
                }, 500);
                
                // Close mobile menu if open
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                }
            }
        });
    });
    
    // Header resize on orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            handleScroll();
        }, 100);
    });
    
    // Intersection Observer for navigation highlighting (for single page sites)
    if ('IntersectionObserver' in window) {
        const sections = document.querySelectorAll('section[id]');
        
        if (sections.length > 0) {
            const observerOptions = {
                root: null,
                rootMargin: `${-(header.offsetHeight + getAdminBarHeight())}px 0px -50% 0px`,
                threshold: 0
            };
            
            const sectionObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        const correspondingLink = document.querySelector(`a[href="#${id}"]`);
                        
                        // Remove active class from all links
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        
                        // Add active class to current section's link
                        if (correspondingLink) {
                            correspondingLink.classList.add('active');
                        }
                    }
                });
            }, observerOptions);
            
            sections.forEach(section => {
                sectionObserver.observe(section);
            });
        }
    }
    
    // Add loading animation on navigation clicks
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't add loading for hash links (same page)
            if (!this.getAttribute('href').startsWith('#')) {
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
                
                // Reset after a short delay in case navigation fails
                setTimeout(() => {
                    this.style.opacity = '';
                    this.style.pointerEvents = '';
                }, 3000);
            }
        });
    });
    
    // Performance optimization: Debounce resize events
    let resizeTimeout;
    window.addEventListener('resize', function() {
        if (resizeTimeout) {
            clearTimeout(resizeTimeout);
        }
        resizeTimeout = setTimeout(() => {
            handleScroll();
        }, 250);
    });
});

// Utility function to detect if user prefers reduced motion
function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

// Apply reduced motion preferences
if (prefersReducedMotion()) {
    document.documentElement.style.scrollBehavior = 'auto';
}
