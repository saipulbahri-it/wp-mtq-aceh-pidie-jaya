<?php
/**
 * Template part for displaying YouTube Live Stream
 *
 * @package MTQ_Aceh_Pidie_Jaya
 */

// Check if YouTube Live is active
$youtube_status = get_option('mtq_youtube_status', 'hidden');

if ($youtube_status === 'hidden') {
    return;
}

// Get YouTube Live display instance
$youtube_display = new MTQ_YouTube_Live_Display();

// Get YouTube settings
$youtube_url = get_option('mtq_youtube_url', '');
$youtube_title = get_option('mtq_youtube_title', 'Live Streaming MTQ Aceh XXXVII Pidie Jaya 2025');
$youtube_description = get_option('mtq_youtube_description', '');

// Get background settings
$background_type = get_option('mtq_youtube_background_type', 'transparent');
$background_color = get_option('mtq_youtube_background_color', '#f8fafc');
$background_gradient = get_option('mtq_youtube_background_gradient', 'from-blue-50 to-indigo-50');

// Build background classes
$background_classes = '';
$background_styles = '';

switch ($background_type) {
    case 'solid':
        $background_styles = 'background-color: ' . esc_attr($background_color) . ';';
        break;
    case 'gradient':
        $background_classes = 'bg-gradient-to-br ' . esc_attr($background_gradient);
        
        // Add fallback gradient styles for better compatibility
        $gradient_map = array(
            'from-blue-50 to-indigo-50' => 'linear-gradient(to bottom right, #eff6ff, #eef2ff)',
            'from-red-50 to-pink-50' => 'linear-gradient(to bottom right, #fef2f2, #fdf2f8)',
            'from-green-50 to-emerald-50' => 'linear-gradient(to bottom right, #f0fdf4, #ecfdf5)',
            'from-yellow-50 to-orange-50' => 'linear-gradient(to bottom right, #fefce8, #fff7ed)',
            'from-purple-50 to-violet-50' => 'linear-gradient(to bottom right, #faf5ff, #f5f3ff)',
            'from-gray-50 to-slate-50' => 'linear-gradient(to bottom right, #f9fafb, #f8fafc)',
            'from-teal-50 to-cyan-50' => 'linear-gradient(to bottom right, #f0fdfa, #ecfeff)',
            'from-rose-50 to-pink-50' => 'linear-gradient(to bottom right, #fff1f2, #fdf2f8)'
        );
        
        // Always use inline styles for gradient to ensure compatibility
        if (isset($gradient_map[$background_gradient])) {
            $background_styles = 'background: ' . $gradient_map[$background_gradient] . ';';
            $background_classes = ''; // Clear Tailwind classes since we're using inline styles
        }
        break;
    case 'transparent':
    default:
        // No background
        break;
}

if (empty($youtube_url)) {
    return;
}

// Debug: Output current settings as HTML comments (remove in production)
if (defined('WP_DEBUG') && WP_DEBUG) {
    echo '<!-- YouTube Live Debug:';
    echo ' background_type=' . esc_html($background_type);
    echo ' background_color=' . esc_html($background_color);
    echo ' background_gradient=' . esc_html($background_gradient);
    echo ' background_classes=' . esc_html($background_classes);
    echo ' background_styles=' . esc_html($background_styles);
    echo ' -->';
}
?>

<!-- YouTube Live Stream Section (match exact snippet) -->
<?php
    // Tentukan kelas/inline bg dari admin jika diatur, fallback ke kuning-oranye
    $section_classes = 'py-20 section-animate relative visible';
    $section_style = '';
    $section_bg_classes = 'bg-gradient-to-br from-yellow-50 to-orange-50';
    if ($background_type === 'gradient') {
        // sudah dihitung sebelumnya $background_styles atau $background_classes
        if (!empty($background_styles)) {
            $section_style = $background_styles;
            $section_bg_classes = '';
        } elseif (!empty($background_classes)) {
            $section_bg_classes = $background_classes;
        }
    } elseif ($background_type === 'solid') {
        $section_style = $background_styles;
        $section_bg_classes = '';
    } elseif ($background_type === 'transparent') {
        $section_bg_classes = '';
    }

    // Siapkan judul & deskripsi
    $title_text = !empty($youtube_title) ? $youtube_title : 'Saksikan MTQ Aceh XXXVII Secara Langsung';
    $desc_text  = !empty($youtube_description) ? $youtube_description : 'Ikuti siaran langsung pelaksanaan MTQ Aceh XXXVII di Pidie Jaya melalui kanal YouTube berikut.';

    // Parse URL YouTube admin ke embed src
    $embed_src = 'https://www.youtube.com/embed/2Gub8-cSH9c'; // default fallback
    if (!empty($youtube_url)) {
        // Ambil ID video dari URL umum atau embed
        $video_id = '';
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/))([\w-]{11})~', $youtube_url, $m)) {
            $video_id = $m[1];
        }
        if (!empty($video_id)) {
            $embed_src = 'https://www.youtube.com/embed/' . $video_id;
        }
    }
?>
<section id="live-stream" class="<?php echo esc_attr($section_bg_classes . ' ' . $section_classes); ?>" <?php echo $section_style ? 'style="' . esc_attr($section_style) . '"' : ''; ?>>
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-10 fade-in-activated" style="animation-delay: 0.00315816s;">
                    <span class="inline-block bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        Live Streaming
                    </span>
                                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">
                                    <?php echo esc_html($title_text); ?>
                                </h2>
                                <p class="text-slate-600 mb-6">
                                    <?php echo esc_html($desc_text); ?>
                                </p>
                </div>
                            <div class="w-full aspect-w-16 aspect-h-9 rounded-xl overflow-hidden relative fade-in-activated" style="animation-delay: 0.0603615s;">
                                <iframe src="<?php echo esc_url($embed_src); ?>" title="Live MTQ Aceh XXXVII" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="w-full h-full min-h-[320px] md:min-h-[480px] rounded-xl" loading="lazy"></iframe>
                    <!-- Tombol Fullscreen Overlay -->
                    <button id="open-video-overlay" class="absolute bottom-4 right-4 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-full shadow-lg flex items-center gap-2 transition" style="z-index:2" aria-label="Tampilkan Layar Penuh">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3H5a2 2 0 0 0-2 2v3m0 8v3a2 2 0 0 0 2 2h3m8-16h3a2 2 0 0 1 2 2v3m0 8v3a2 2 0 0 1-2 2h-3"></path>
                        </svg>
                        Fullscreen
                    </button>
                </div>
        
            </div>

            <!-- Overlay Video Fullscreen -->
            <div id="video-overlay" class="fixed inset-0 bg-black/90 flex items-center justify-center z-[9999] hidden">
                <button id="close-video-overlay" class="absolute top-6 right-8 text-white bg-black/40 hover:bg-black/70 rounded-full p-3 transition" aria-label="Tutup Video" style="z-index:10001">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                        <div class="w-full max-w-6xl aspect-w-16 aspect-h-9">
                            <iframe src="<?php echo esc_url($embed_src); ?>?autoplay=1" title="Live MTQ Aceh XXXVII" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="w-full h-full rounded-lg shadow-2xl" loading="lazy"></iframe>
                </div>
            </div>
        </section>

<style>
/* (Removed old wrapper styles; using direct iframe block as per snippet) */

/* Ensure consistent styling with theme */
.replay-message {
    line-height: 1.6;
    margin-top: 1rem;
}

/* Fallback CSS for Tailwind gradient classes */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-from), var(--tw-gradient-to));
}

/* Gradient fallbacks for better compatibility */
.bg-gradient-to-br.from-blue-50.to-indigo-50 {
    background: linear-gradient(to bottom right, #eff6ff, #eef2ff);
}

.bg-gradient-to-br.from-red-50.to-pink-50 {
    background: linear-gradient(to bottom right, #fef2f2, #fdf2f8);
}

.bg-gradient-to-br.from-green-50.to-emerald-50 {
    background: linear-gradient(to bottom right, #f0fdf4, #ecfdf5);
}

.bg-gradient-to-br.from-yellow-50.to-orange-50 {
    background: linear-gradient(to bottom right, #fefce8, #fff7ed);
}

.bg-gradient-to-br.from-purple-50.to-violet-50 {
    background: linear-gradient(to bottom right, #faf5ff, #f5f3ff);
}

.bg-gradient-to-br.from-gray-50.to-slate-50 {
    background: linear-gradient(to bottom right, #f9fafb, #f8fafc);
}

.bg-gradient-to-br.from-teal-50.to-cyan-50 {
    background: linear-gradient(to bottom right, #f0fdfa, #ecfeff);
}

.bg-gradient-to-br.from-rose-50.to-pink-50 {
    background: linear-gradient(to bottom right, #fff1f2, #fdf2f8);
}

/* Live CTA Styles */
.live-cta {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.live-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #dc3545;
    font-size: 1.1rem;
}

.live-dot {
    width: 12px;
    height: 12px;
    background: #dc3545;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1); 
    }
    50% { 
        opacity: 0.5; 
        transform: scale(1.2); 
    }
}

.live-message, .upcoming-message, .replay-message {
    color: #333;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* Share Buttons */
.live-share-buttons {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.share-label {
    color: #666;
    font-size: 0.9rem;
    margin-right: 0.5rem;
}

.social-share-buttons {
    display: flex;
    gap: 0.5rem;
}

.social-share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.social-share-btn.facebook { background: #1877f2; }
.social-share-btn.whatsapp { background: #25d366; }
.social-share-btn.twitter { background: #1da1f2; }
.social-share-btn.telegram { background: #0088cc; }
.social-share-btn.copy { background: #6c757d; }

/* Upcoming CTA */
.upcoming-cta {
    background: rgba(255, 243, 205, 0.95);
    border-radius: 15px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.upcoming-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #856404;
    font-size: 1.1rem;
}

.upcoming-clock {
    font-size: 1.2rem;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

/* Replay CTA */
.replay-cta {
    background: rgba(212, 237, 218, 0.95);
    border-radius: 15px;
    padding: 2rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.replay-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #155724;
    font-size: 1.1rem;
}

.replay-icon {
    font-size: 1.2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .mtq-youtube-live-homepage {
        padding: 2rem 0;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .live-cta, .upcoming-cta, .replay-cta {
        padding: 1.5rem;
    }
    
    .live-share-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .share-label {
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
// Live Stream Sharing Functions
function shareLiveStream(platform) {
    const url = encodeURIComponent(window.location.href + '#live-stream');
    const title = encodeURIComponent('Saksikan Live Streaming MTQ Aceh XXXVII Pidie Jaya 2025');
    const description = encodeURIComponent('Jangan lewatkan kompetisi MTQ Aceh XXXVII yang menampilkan para qari dan qariah terbaik!');
    
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${title} ${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'telegram':
            shareUrl = `https://t.me/share/url?url=${url}&text=${title}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
        
        // Track sharing
        if (typeof mtq_youtube_ajax !== 'undefined') {
            jQuery.ajax({
                url: mtq_youtube_ajax.ajax_url,
                method: 'POST',
                data: {
                    action: 'mtq_track_social_share',
                    nonce: mtq_youtube_ajax.nonce,
                    platform: platform,
                    type: 'youtube_live'
                }
            });
        }
    }
}

function copyLiveStreamLink() {
    const url = window.location.href + '#live-stream';
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            showNotification('Link berhasil disalin!', 'success');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showNotification('Link berhasil disalin!', 'success');
    }
}

function setReminder() {
    // Simple reminder using localStorage
    localStorage.setItem('mtq_live_reminder', 'true');
    showNotification('Reminder berhasil diatur! Kami akan mengingatkan Anda.', 'success');
    
    // In a real implementation, you might:
    // - Send push notification
    // - Save to user preferences
    // - Send email reminder
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `mtq-notification mtq-notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : '#17a2b8'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Slide in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
}
</script>
