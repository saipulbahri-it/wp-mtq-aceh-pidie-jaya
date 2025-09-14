/**
 * File navigation.js.
 *
 * Simple and reliable mobile navigation for MTQ Aceh Pidie Jaya theme
 */

(function() {
    'use strict';
    
    console.log('🚀 Navigation script loaded');
    
    // Wait for DOM to be ready
    function initNavigation() {
        console.log('🎯 Initializing navigation...');
        
        // Get mobile navigation elements
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        console.log('Mobile button:', mobileMenuBtn);
        console.log('Mobile menu:', mobileMenu);
        
        if (!mobileMenuBtn || !mobileMenu) {
            console.log('❌ Mobile navigation elements not found!');
            return;
        }
        
        console.log('✅ Mobile navigation elements found');
        
        // Set initial state
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        
        // Toggle function
        function toggleMobileMenu(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling
            console.log('🔥 Mobile menu button clicked!');
            
            const isHidden = mobileMenu.classList.contains('hidden');
            console.log('Menu currently hidden:', isHidden);
            
            if (isHidden) {
                // Show menu
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                
                // Change icon to X
                const path = mobileMenuBtn.querySelector('svg path');
                if (path) {
                    path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                }
                
                console.log('✅ Menu opened');
            } else {
                // Hide menu
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                
                // Change icon to hamburger
                const path = mobileMenuBtn.querySelector('svg path');
                if (path) {
                    path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
                
                console.log('✅ Menu closed');
            }
        }
        
        // Add click event listener
        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        
        // Close menu when clicking outside (with delay to prevent immediate closing)
        setTimeout(function() {
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'false');
                        
                        // Reset icon to hamburger
                        const path = mobileMenuBtn.querySelector('svg path');
                        if (path) {
                            path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                        }
                        
                        console.log('Menu closed by outside click');
                    }
                }
            });
        }, 100); // Small delay to prevent immediate triggering
        
        // Close menu when clicking on links
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                
                // Reset icon to hamburger
                const path = mobileMenuBtn.querySelector('svg path');
                if (path) {
                    path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
                
                console.log('Menu closed by link click');
            });
        });
        
        // Close menu on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                
                // Reset icon to hamburger
                const path = mobileMenuBtn.querySelector('svg path');
                if (path) {
                    path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
                
                console.log('Menu closed due to screen resize');
            }
        });
        
        console.log('🎉 Mobile navigation initialized successfully!');
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavigation);
    } else {
        initNavigation();
    }
    
    // Fallback for window load
    window.addEventListener('load', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        
        if (btn && menu && !btn.hasAttribute('data-nav-init')) {
            console.log('🔄 Fallback initialization...');
            initNavigation();
            btn.setAttribute('data-nav-init', 'true');
        }
    });
    
})();
