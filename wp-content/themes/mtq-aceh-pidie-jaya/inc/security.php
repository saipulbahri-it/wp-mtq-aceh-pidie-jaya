<?php
/**
 * Security and HTTPS related functions
 */

if (!defined('ABSPATH')) { exit; }

// Force HTTPS for all URLs
function mtq_force_https_urls() {
	if (!is_ssl() && !is_admin()) {
		if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			$_SERVER['HTTPS'] = 'on';
		}
	}
}
add_action('init', 'mtq_force_https_urls');

// Replace HTTP with HTTPS in content
function mtq_replace_http_with_https($content) {
	$content = str_replace('http://mtq.pidiejayakab.go.id', 'https://mtq.pidiejayakab.go.id', $content);
	return $content;
}
add_filter('the_content', 'mtq_replace_http_with_https');
add_filter('widget_text', 'mtq_replace_http_with_https');

// Add security headers
function mtq_add_security_headers() {
	if (!headers_sent()) {
		header('X-Frame-Options: SAMEORIGIN');
		header('X-XSS-Protection: 1; mode=block');
		header('X-Content-Type-Options: nosniff');
		header('Referrer-Policy: strict-origin-when-cross-origin');
		if (is_ssl()) {
			header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
		}
	}
}
add_action('send_headers', 'mtq_add_security_headers');

// Security logging helper
function mtq_log_security_event($event, $details = array()) {
	if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
		$log_entry = array(
			'timestamp' => current_time('mysql'),
			'event' => $event,
			'details' => $details,
			'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
		);
		error_log('[MTQ SECURITY] ' . json_encode($log_entry));
	}
}
