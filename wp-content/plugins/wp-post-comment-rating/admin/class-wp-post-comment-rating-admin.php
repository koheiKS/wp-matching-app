<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/shoaib88/
 * @since      2.4
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/admin
 */


class WP_Post_Comment_Rating_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.4
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.4
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.4
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.4
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-post-comment-rating-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.4
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-post-comment-rating-admin.js', array( 'jquery', 'wp-color-picker'), $this->version, false );

	}
	/**
	*** Function to register form fields
	**/
	public function wpcr_register_options(){
		register_setting('wpcr_options_group', 'wpcr_settings', 'wpcr_validate');
	}

	/**
	*** Function to add hyperlinks to the admin menus using hooks and filters
	**/
	public function wpcr_admin_links() {
	  $option_page = add_options_page('Rating Setup', 'Post Rating', 'manage_options', 'commentrating', array( $this, 'wpcr_menu_section_display' ) );
	  }
	
	public function wpcr_menu_section_display(){
		if ( current_user_can( 'manage_options' ) ) {
	    ob_start();
	    include_once plugin_dir_path( __FILE__ ) . 'partials/wp-post-comment-rating-admin-display.php';
			echo ob_get_clean();
		} else {
			echo '<p>' . esc_html__( 'You do not have adequate permissions for this action!', 'wp-post-comment-rating' ) . '</p>';
		}
  }
	/**
	*** Validate User Input
	**/
	public function wpcr_validate($input) {
	  return array_map('wp_filter_nohtml_kses', (array)$input);
	}

}
