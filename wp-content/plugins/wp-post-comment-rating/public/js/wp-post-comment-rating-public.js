(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery( document ).ready(function() {
		jQuery( ".wpcr_author_stars" ).each(function() { 
			// Get the value
			var val = jQuery(this).data("rating");
			// Make sure that the value is in 0 - 5 range, multiply to get width
			var size = Math.max(0, (Math.min(5, val))) * 16;
			// Create stars holder
			var $span = jQuery('<span />').width(size);
			// Replace the numerical value with stars
			jQuery(this).html($span);
		});
		
		
		jQuery( ".wpcr_averageStars" ).each(function() { 
			// Get the value
			var val1 = jQuery(this).data("wpcravg");
			//alert(val1);
			// Make sure that the value is in 0 - 5 range, multiply to get width
			var size1 = Math.max(0, (Math.min(5, val1))) * 16;
			// Create stars holder
			var $span1 = jQuery('<span />').width(size1);
			// Replace the numerical value with stars
			jQuery(this).html($span1);
		});
	


	jQuery( ".comment-reply a.comment-reply-link, .reply a.comment-reply-link, .comment-reply" ).click(function() {
		jQuery('fieldset.wppcr_rating').addClass('disabled');
			setTimeout(function(){
				jQuery('.wppcr_rating.disabled').css({"display": "none", "pointer-events": "none"});
			}, 100);
	});
	jQuery( "#cancel-comment-reply-link" ).click(function() {
		jQuery('fieldset.wppcr_rating').removeClass('disabled').removeAttr("style")
	});
	
    // Show the div in 5s
    jQuery(".wpcr_floating_links").delay(3000).fadeIn(300);
	
	
});
		
	
})( jQuery );
