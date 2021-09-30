<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/shoaib88/
 * @since      2.4
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.4
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/includes
 * @author     Shoaib Saleem <shoaibsaleem20@gmail.com>
 */
class WP_Post_Comment_Rating_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.4
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-post-comment-rating',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
