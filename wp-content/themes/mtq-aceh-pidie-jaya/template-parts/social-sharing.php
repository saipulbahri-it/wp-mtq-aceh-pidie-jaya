<?php
/**
 * Social Sharing Buttons with Analytics
 * 
 * This template part displays social sharing buttons for posts
 * with built-in analytics tracking and modern design
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Get current post data
$post_url = get_permalink();
$post_title = get_the_title();
$post_excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
$post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
$site_name = get_bloginfo('name');

// Encode data for URLs
$encoded_url = urlencode($post_url);
$encoded_title = urlencode($post_title);
$encoded_excerpt = urlencode($post_excerpt);
$encoded_site_name = urlencode($site_name);

// Social media sharing URLs
$social_networks = array(
    'facebook' => array(
        'url' => "https://www.facebook.com/sharer/sharer.php?u={$encoded_url}",
        'name' => 'Facebook',
        'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
        'color' => 'bg-blue-600 hover:bg-blue-700',
        'analytics_label' => 'Facebook'
    ),
    'twitter' => array(
        'url' => "https://twitter.com/intent/tweet?url={$encoded_url}&text={$encoded_title}&via=" . get_option('twitter_username', 'mtqacehjaya'),
        'name' => 'Twitter / X',
        'icon' => 'M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z',
        'color' => 'bg-slate-900 hover:bg-black',
        'analytics_label' => 'Twitter'
    ),
    'whatsapp' => array(
        'url' => "https://wa.me/?text={$encoded_title}%20{$encoded_url}",
        'name' => 'WhatsApp',
        'icon' => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488',
        'color' => 'bg-green-600 hover:bg-green-700',
        'analytics_label' => 'WhatsApp'
    ),
    'telegram' => array(
        'url' => "https://t.me/share/url?url={$encoded_url}&text={$encoded_title}",
        'name' => 'Telegram',
        'icon' => 'M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z',
        'color' => 'bg-blue-500 hover:bg-blue-600',
        'analytics_label' => 'Telegram'
    ),
    'linkedin' => array(
        'url' => "https://www.linkedin.com/sharing/share-offsite/?url={$encoded_url}",
        'name' => 'LinkedIn',
        'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
        'color' => 'bg-blue-700 hover:bg-blue-800',
        'analytics_label' => 'LinkedIn'
    ),
    'pinterest' => array(
        'url' => "https://pinterest.com/pin/create/button/?url={$encoded_url}&media={$post_thumbnail}&description={$encoded_title}",
        'name' => 'Pinterest',
        'icon' => 'M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.739.099.12.112.225.085.345-.09.375-.294 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.752-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001.012.001z',
        'color' => 'bg-red-600 hover:bg-red-700',
        'analytics_label' => 'Pinterest'
    ),
    'email' => array(
        'url' => "mailto:?subject={$encoded_title}&body=Saya menemukan artikel menarik yang ingin saya bagikan:%0D%0A%0D%0A{$encoded_title}%0D%0A{$encoded_url}%0D%0A%0D%0ADari {$encoded_site_name}",
        'name' => 'Email',
        'icon' => 'M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z',
        'color' => 'bg-gray-600 hover:bg-gray-700',
        'analytics_label' => 'Email'
    ),
    'copy' => array(
        'url' => '#',
        'name' => 'Salin Link',
        'icon' => 'M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75',
        'color' => 'bg-slate-600 hover:bg-slate-700',
        'analytics_label' => 'Copy_Link'
    )
);
?>

<!-- Social Sharing Section -->
<div class="mtq-social-sharing py-8 border-t border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50" id="social-sharing">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Bagikan Artikel Ini</h3>
            <p class="text-slate-600 text-lg">Bantu sebarkan informasi bermanfaat ini kepada yang lain</p>
        </div>

        <!-- Social Buttons Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-3 sm:gap-4 mb-8">
            <?php foreach ($social_networks as $network_key => $network) : ?>
            <button 
                class="social-share-btn group relative flex flex-col items-center justify-center w-14 h-14 sm:w-16 sm:h-16 lg:w-18 lg:h-18 rounded-full shadow-lg text-white <?php echo $network['color']; ?>"
                data-network="<?php echo $network_key; ?>"
                data-url="<?php echo esc_attr($network['url']); ?>"
                data-analytics-label="<?php echo $network['analytics_label']; ?>"
                <?php if ($network_key === 'copy') : ?>
                data-copy-url="<?php echo esc_attr($post_url); ?>"
                <?php endif; ?>
                aria-label="Bagikan ke <?php echo esc_attr($network['name']); ?>"
                title="<?php echo esc_attr($network['name']); ?>"
            >
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10 rounded-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent rounded-full"></div>
                </div>
                
                <!-- Icon -->
                <div class="relative z-10 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="<?php echo $network['icon']; ?>"/>
                    </svg>
                </div>
                
                <!-- Hover effect -->
                <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full"></div>
                
                <!-- Ripple effect -->
                <div class="absolute inset-0 rounded-full overflow-hidden">
                    <div class="ripple-effect absolute inset-0 transform scale-0 bg-white/30 rounded-full transition-transform duration-500"></div>
                </div>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Platform Names -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-3 sm:gap-4 mb-8">
            <?php foreach ($social_networks as $network_key => $network) : ?>
            <div class="text-center">
                <span class="text-xs sm:text-sm font-medium text-slate-600"><?php echo $network['name']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Share Statistics -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center space-x-6 bg-white/70 backdrop-blur-sm rounded-2xl px-6 py-4 shadow-lg">
                <!-- Total Shares Counter -->
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-slate-600">Total Dibagikan:</span>
                    <span class="font-bold text-slate-800" id="total-shares-count">
                        <?php echo get_post_meta(get_the_ID(), '_social_shares_count', true) ?: '0'; ?>
                    </span>
                </div>
                
                <!-- Views Counter -->
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-slate-600">Views:</span>
                    <span class="font-bold text-slate-800">
                        <?php echo get_post_meta(get_the_ID(), '_post_views_count', true) ?: '0'; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Thank You Message (Hidden by default) -->
        <div class="hidden text-center mt-6" id="share-thank-you">
            <div class="inline-flex items-center space-x-2 bg-green-100 text-green-800 px-4 py-2 rounded-xl border border-green-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">Terima kasih telah membagikan artikel ini!</span>
            </div>
        </div>
    </div>
</div>

<!-- Social Sharing Analytics & Interactive Features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Track social sharing analytics
    window.mtqTrackSocialShare = function(platform, url) {
        // Google Analytics 4 tracking (if available)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'social_share', {
                'social_network': platform,
                'content_type': 'article',
                'item_id': '<?php echo get_the_ID(); ?>',
                'content_title': '<?php echo esc_js($post_title); ?>',
                'page_url': url
            });
        }
        
        // Facebook Pixel tracking (if available)
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Share', {
                content_type: 'article',
                content_ids: ['<?php echo get_the_ID(); ?>'],
                content_name: '<?php echo esc_js($post_title); ?>'
            });
        }
        
        // Custom analytics endpoint
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'action': 'mtq_track_social_share',
                'post_id': '<?php echo get_the_ID(); ?>',
                'platform': platform,
                'nonce': '<?php echo wp_create_nonce('mtq_social_share_nonce'); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update share counter
                const counterElement = document.getElementById('total-shares-count');
                if (counterElement && data.data.total_shares) {
                    counterElement.textContent = data.data.total_shares;
                    counterElement.classList.add('animate-pulse');
                    setTimeout(() => counterElement.classList.remove('animate-pulse'), 1000);
                }
                
                // Show thank you message
                showThankYouMessage();
            }
        })
        .catch(error => console.log('Analytics tracking error:', error));
    };
    
    // Handle social share button clicks
    document.querySelectorAll('.social-share-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const network = this.getAttribute('data-network');
            const url = this.getAttribute('data-url');
            const analyticsLabel = this.getAttribute('data-analytics-label');
            
            // Add ripple effect
            addRippleEffect(this);
            
            // Handle different sharing methods
            if (network === 'copy') {
                handleCopyLink(this);
            } else {
                // Open sharing popup
                openSocialPopup(url, network);
                mtqTrackSocialShare(analyticsLabel, '<?php echo esc_js($post_url); ?>');
            }
        });
    });
    
    // Copy to clipboard functionality
    function handleCopyLink(button) {
        const copyUrl = button.getAttribute('data-copy-url');
        
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(copyUrl).then(function() {
                showCopySuccess(button);
                mtqTrackSocialShare('Copy_Link', copyUrl);
            }).catch(function() {
                fallbackCopyTextToClipboard(copyUrl, button);
            });
        } else {
            fallbackCopyTextToClipboard(copyUrl, button);
        }
    }
    
    // Fallback copy method for older browsers
    function fallbackCopyTextToClipboard(text, button) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.position = 'fixed';
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopySuccess(button);
            mtqTrackSocialShare('Copy_Link', text);
        } catch (err) {
            console.error('Fallback: Could not copy text');
            showCopyError(button);
        }
        
        document.body.removeChild(textArea);
    }
    
    // Show copy success feedback
    function showCopySuccess(button) {
        const originalText = button.querySelector('span').textContent;
        const span = button.querySelector('span');
        
        span.textContent = '✓ Tersalin';
        button.classList.add('!bg-green-600');
        
        setTimeout(() => {
            span.textContent = originalText;
            button.classList.remove('!bg-green-600');
        }, 2000);
    }
    
    // Show copy error feedback
    function showCopyError(button) {
        const originalText = button.querySelector('span').textContent;
        const span = button.querySelector('span');
        
        span.textContent = '✗ Gagal';
        button.classList.add('!bg-red-600');
        
        setTimeout(() => {
            span.textContent = originalText;
            button.classList.remove('!bg-red-600');
        }, 2000);
    }
    
    // Open social sharing popup
    function openSocialPopup(url, network) {
        const width = 600;
        const height = 400;
        const left = (window.innerWidth - width) / 2;
        const top = (window.innerHeight - height) / 2;
        
        const popup = window.open(
            url,
            'social-share-' + network,
            `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
        );
        
        // Focus the popup
        if (popup && popup.focus) {
            popup.focus();
        }
        
        return popup;
    }
    
    // Add ripple effect to buttons
    function addRippleEffect(button) {
        const ripple = button.querySelector('.ripple-effect');
        if (ripple) {
            ripple.classList.remove('scale-0');
            ripple.classList.add('scale-100');
            setTimeout(() => {
                ripple.classList.remove('scale-100');
                ripple.classList.add('scale-0');
            }, 500);
        }
    }
    
    // Show thank you message
    function showThankYouMessage() {
        const thankYouElement = document.getElementById('share-thank-you');
        if (thankYouElement) {
            thankYouElement.classList.remove('hidden');
            setTimeout(() => {
                thankYouElement.classList.add('hidden');
            }, 3000);
        }
    }
    
    // Animate counters on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('#total-shares-count, [id*="counter"]');
                counters.forEach(animateCounter);
            }
        });
    }, observerOptions);
    
    const socialSection = document.getElementById('social-sharing');
    if (socialSection) {
        observer.observe(socialSection);
    }
    
    // Animate counter numbers
    function animateCounter(element) {
        const targetNumber = parseInt(element.textContent) || 0;
        if (targetNumber === 0) return;
        
        let currentNumber = 0;
        const increment = Math.ceil(targetNumber / 20);
        
        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= targetNumber) {
                currentNumber = targetNumber;
                clearInterval(timer);
            }
            element.textContent = currentNumber;
        }, 50);
    }
});

// Add custom styles for animations
const style = document.createElement('style');
style.textContent = `
    .animate-pulse {
        animation: pulse 1s ease-in-out;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .ripple-effect {
        pointer-events: none;
    }
    
    .social-share-btn:hover .ripple-effect {
        animation: ripple 0.6s linear;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

<?php
// Add structured data for social sharing
$structured_data = array(
    "@context" => "https://schema.org",
    "@type" => "SocialMediaPosting",
    "headline" => $post_title,
    "datePublished" => get_the_date('c'),
    "dateModified" => get_the_modified_date('c'),
    "author" => array(
        "@type" => "Person",
        "name" => get_the_author()
    ),
    "publisher" => array(
        "@type" => "Organization",
        "name" => $site_name,
        "url" => home_url()
    ),
    "mainEntityOfPage" => array(
        "@type" => "WebPage",
        "@id" => $post_url
    ),
    "url" => $post_url,
    "description" => $post_excerpt,
    "sharedContent" => array(
        "@type" => "WebPage",
        "url" => $post_url,
        "headline" => $post_title
    )
);

if ($post_thumbnail) {
    $structured_data["image"] = array(
        "@type" => "ImageObject",
        "url" => $post_thumbnail,
        "width" => 1200,
        "height" => 630
    );
}
?>

<!-- Schema.org Structured Data for Social Sharing -->
<script type="application/ld+json">
<?php echo json_encode($structured_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>
