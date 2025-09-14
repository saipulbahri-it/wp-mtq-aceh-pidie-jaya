/**
 * MTQ YouTube Live Stream JavaScript
 * 
 * @package MTQ_Aceh_Pidie_Jaya
 */

(function($) {
    'use strict';

    /**
     * MTQ YouTube Live Class
     */
    class MTQYouTubeLive {
        constructor() {
            this.init();
        }

        /**
         * Initialize YouTube Live functionality
         */
        init() {
            this.bindEvents();
            this.setupAutoRefresh();
            this.setupViewerCount();
            this.setupChatToggle();
            this.setupResponsiveEmbed();
            this.setupAccessibility();
        }

        /**
         * Bind event handlers
         */
        bindEvents() {
            $(document).ready(() => {
                this.onDocumentReady();
            });

            $(window).on('resize', this.debounce(() => {
                this.handleResize();
            }, 250));

            $(window).on('orientationchange', () => {
                setTimeout(() => {
                    this.handleResize();
                }, 100);
            });
        }

        /**
         * Document ready handler
         */
        onDocumentReady() {
            this.enhanceEmbeds();
            this.setupLazyLoading();
            this.addLoadingStates();
            this.setupKeyboardNavigation();
        }

        /**
         * Enhanced embed functionality
         */
        enhanceEmbeds() {
            $('.mtq-youtube-embed iframe').each((index, iframe) => {
                const $iframe = $(iframe);
                const $container = $iframe.closest('.mtq-youtube-embed');

                // Add loading indicator
                $container.addClass('mtq-youtube-loading');

                // Handle iframe load
                $iframe.on('load', () => {
                    $container.removeClass('mtq-youtube-loading');
                    this.trackVideoView($iframe.attr('src'));
                });

                // Handle iframe error
                $iframe.on('error', () => {
                    $container.removeClass('mtq-youtube-loading');
                    this.showError($container);
                });

                // Setup intersection observer for analytics
                this.setupIntersectionObserver($iframe[0]);
            });
        }

        /**
         * Setup lazy loading for YouTube embeds
         */
        setupLazyLoading() {
            if ('IntersectionObserver' in window) {
                const lazyObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const $embed = $(entry.target);
                            this.loadYouTubeEmbed($embed);
                            lazyObserver.unobserve(entry.target);
                        }
                    });
                });

                $('.mtq-youtube-embed[data-lazy]').each((index, element) => {
                    lazyObserver.observe(element);
                });
            }
        }

        /**
         * Load YouTube embed
         */
        loadYouTubeEmbed($embed) {
            const videoId = $embed.data('video-id');
            const autoplay = $embed.data('autoplay') ? 1 : 0;
            const controls = $embed.data('controls') ? 1 : 0;

            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=${autoplay}&controls=${controls}&rel=0&modestbranding=1`;
                
                const $iframe = $('<iframe>', {
                    src: embedUrl,
                    frameborder: 0,
                    allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                    allowfullscreen: true,
                    title: 'YouTube Live Stream MTQ Aceh Pidie Jaya'
                });

                $embed.append($iframe);
            }
        }

        /**
         * Setup auto-refresh for live status
         */
        setupAutoRefresh() {
            const $liveStatus = $('.youtube-live-status.status-live');
            
            if ($liveStatus.length) {
                setInterval(() => {
                    this.checkLiveStatus();
                }, 30000); // Check every 30 seconds
            }
        }

        /**
         * Check live status via AJAX
         */
        checkLiveStatus() {
            if (typeof mtq_youtube_ajax === 'undefined') return;

            $.ajax({
                url: mtq_youtube_ajax.ajax_url,
                method: 'POST',
                data: {
                    action: 'mtq_check_live_status',
                    nonce: mtq_youtube_ajax.nonce
                },
                success: (response) => {
                    if (response.success && response.data.status_changed) {
                        this.updateLiveStatus(response.data);
                    }
                },
                error: () => {
                    console.log('Failed to check live status');
                }
            });
        }

        /**
         * Update live status display
         */
        updateLiveStatus(data) {
            const $statusElement = $('.youtube-live-status');
            
            if ($statusElement.length) {
                $statusElement
                    .removeClass('status-live status-upcoming status-ended status-replay status-hidden')
                    .addClass(`status-${data.status}`)
                    .text(data.status_text);

                // If status changed to ended, show notification
                if (data.status === 'ended') {
                    this.showStatusChangeNotification('Live stream telah berakhir', 'info');
                } else if (data.status === 'live') {
                    this.showStatusChangeNotification('Live stream sedang berlangsung!', 'success');
                }
            }
        }

        /**
         * Setup viewer count display
         */
        setupViewerCount() {
            const $viewerCount = $('.mtq-youtube-stat-number[data-stat="viewers"]');
            
            if ($viewerCount.length) {
                this.updateViewerCount();
                setInterval(() => {
                    this.updateViewerCount();
                }, 60000); // Update every minute
            }
        }

        /**
         * Update viewer count
         */
        updateViewerCount() {
            if (typeof mtq_youtube_ajax === 'undefined') return;

            $.ajax({
                url: mtq_youtube_ajax.ajax_url,
                method: 'POST',
                data: {
                    action: 'mtq_get_viewer_count',
                    nonce: mtq_youtube_ajax.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $('.mtq-youtube-stat-number[data-stat="viewers"]')
                            .text(this.formatNumber(response.data.viewers));
                    }
                }
            });
        }

        /**
         * Setup chat toggle for mobile
         */
        setupChatToggle() {
            const $chatContainer = $('.mtq-youtube-chat');
            
            if ($chatContainer.length) {
                // Add toggle button for mobile
                const $toggleButton = $('<button>', {
                    class: 'mtq-chat-toggle',
                    text: '💬 Tampilkan Chat',
                    'aria-label': 'Toggle YouTube Chat'
                });

                $toggleButton.on('click', () => {
                    $chatContainer.toggleClass('chat-visible');
                    const isVisible = $chatContainer.hasClass('chat-visible');
                    $toggleButton.text(isVisible ? '💬 Sembunyikan Chat' : '💬 Tampilkan Chat');
                });

                // Only show toggle on mobile
                if (window.innerWidth < 1024) {
                    $chatContainer.before($toggleButton);
                }
            }
        }

        /**
         * Setup responsive embed
         */
        setupResponsiveEmbed() {
            this.handleResize();
        }

        /**
         * Handle window resize
         */
        handleResize() {
            const $embeds = $('.mtq-youtube-embed');
            const isMobile = window.innerWidth < 768;
            
            $embeds.each((index, embed) => {
                const $embed = $(embed);
                
                if (isMobile) {
                    $embed.addClass('mobile-optimized');
                } else {
                    $embed.removeClass('mobile-optimized');
                }
            });

            // Handle chat visibility
            const $chat = $('.mtq-youtube-chat');
            const $chatToggle = $('.mtq-chat-toggle');
            
            if (window.innerWidth >= 1024) {
                $chat.show();
                $chatToggle.hide();
            } else {
                $chat.hide();
                if ($chatToggle.length === 0) {
                    this.setupChatToggle();
                } else {
                    $chatToggle.show();
                }
            }
        }

        /**
         * Setup accessibility features
         */
        setupAccessibility() {
            // Add ARIA labels
            $('.youtube-live-status').each((index, element) => {
                const $element = $(element);
                const status = $element.text();
                $element.attr('aria-label', `Status live stream: ${status}`);
            });

            // Add keyboard navigation for embeds
            $('.mtq-youtube-embed iframe').attr('tabindex', '0');

            // Add focus indicators
            $('.mtq-youtube-embed iframe').on('focus', function() {
                $(this).closest('.mtq-youtube-embed').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.mtq-youtube-embed').removeClass('focused');
            });
        }

        /**
         * Setup keyboard navigation
         */
        setupKeyboardNavigation() {
            $(document).on('keydown', (e) => {
                // Space bar to play/pause (when iframe is focused)
                if (e.code === 'Space' && document.activeElement.tagName === 'IFRAME') {
                    e.preventDefault();
                    // YouTube iframe will handle play/pause
                }

                // Escape to exit fullscreen
                if (e.code === 'Escape') {
                    this.exitFullscreen();
                }
            });
        }

        /**
         * Setup intersection observer for analytics
         */
        setupIntersectionObserver(iframe) {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && entry.intersectionRatio > 0.5) {
                            this.trackVideoView(iframe.src, 'viewed');
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(iframe);
            }
        }

        /**
         * Track video view
         */
        trackVideoView(src, action = 'loaded') {
            if (typeof mtq_youtube_ajax === 'undefined') return;

            const videoId = this.extractVideoId(src);
            
            if (videoId) {
                $.ajax({
                    url: mtq_youtube_ajax.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'mtq_track_youtube_view',
                        nonce: mtq_youtube_ajax.nonce,
                        video_id: videoId,
                        view_action: action
                    }
                });
            }
        }

        /**
         * Extract video ID from YouTube URL
         */
        extractVideoId(url) {
            const regex = /(?:youtube\.com\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]+)/;
            const match = url.match(regex);
            return match ? match[1] : null;
        }

        /**
         * Add loading states
         */
        addLoadingStates() {
            $('.mtq-youtube-embed').each((index, embed) => {
                const $embed = $(embed);
                
                if (!$embed.find('iframe').length) {
                    $embed.addClass('mtq-youtube-loading');
                }
            });
        }

        /**
         * Show error message
         */
        showError($container) {
            const $error = $('<div>', {
                class: 'mtq-youtube-error',
                html: '<p><strong>Maaf, terjadi kesalahan saat memuat video.</strong></p><p>Silakan refresh halaman atau coba lagi nanti.</p>'
            });

            $container.empty().append($error);
        }

        /**
         * Show status change notification
         */
        showStatusChangeNotification(message, type = 'info') {
            const $notification = $('<div>', {
                class: `mtq-notification mtq-notification-${type}`,
                text: message
            });

            $('body').append($notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                $notification.fadeOut(() => {
                    $notification.remove();
                });
            }, 5000);
        }

        /**
         * Exit fullscreen
         */
        exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }

        /**
         * Format number for display
         */
        formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return num.toString();
        }

        /**
         * Debounce function
         */
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(() => {
        new MTQYouTubeLive();
    });

    /**
     * Global functions for external access
     */
    window.MTQYouTubeLive = {
        /**
         * Refresh live status manually
         */
        refreshStatus: function() {
            if (window.mtqYouTubeLive) {
                window.mtqYouTubeLive.checkLiveStatus();
            }
        },

        /**
         * Toggle chat visibility
         */
        toggleChat: function() {
            $('.mtq-youtube-chat').toggleClass('chat-visible');
        },

        /**
         * Update viewer count manually
         */
        updateViewerCount: function() {
            if (window.mtqYouTubeLive) {
                window.mtqYouTubeLive.updateViewerCount();
            }
        }
    };

})(jQuery);
