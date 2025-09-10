/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	'use strict';

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Footer text
	wp.customize( 'footer_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer .footer-text' ).html( to );
		} );
	} );

	// Footer address
	wp.customize( 'footer_address', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer .footer-address' ).html( to );
		} );
	} );

	// Footer email
	wp.customize( 'footer_email', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer .footer-email' )
				.attr( 'href', 'mailto:' + to )
				.text( to );
		} );
	} );

	// Footer phone
	wp.customize( 'footer_phone', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer .footer-phone' )
				.attr( 'href', 'tel:' + to )
				.text( to );
		} );
	} );

	// Social media links
	const socialPlatforms = ['facebook', 'instagram', 'youtube', 'twitter'];
	socialPlatforms.forEach( function( platform ) {
		wp.customize( 'footer_social_' + platform, function( value ) {
			value.bind( function( to ) {
				const $link = $( '.site-footer .footer-social-' + platform );
				if ( to ) {
					$link.attr( 'href', to ).show();
				} else {
					$link.hide();
				}
			} );
		} );
	} );

} )( jQuery );