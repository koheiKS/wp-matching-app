(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
	
	jQuery(document).ready(function($){
    $('.wpcrcolor-field').wpColorPicker();
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
	
	$('.tab-a').click(function(){  
			window.location.hash=""
		  $(".tab").removeClass('tab-active');
		  $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
		  $(".tab-a").removeClass('active-a');
		  $(this).parent().find(".tab-a").addClass('active-a');
		 });
	
});
	
})( jQuery );
