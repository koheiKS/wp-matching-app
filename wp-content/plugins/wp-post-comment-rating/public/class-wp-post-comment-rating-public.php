<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/shoaib88/
 * @since      2.4
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/public
 * @author     Shoaib Saleem <shoaibsaleem20@gmail.com>
 */
class WP_Post_Comment_Rating_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.4
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-post-comment-rating-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.4
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-post-comment-rating-public.js', array( 'jquery' ), $this->version, false );
		
	}
	//---------------------------------------------------
	// SHORTCODES
	//---------------------------------------------------

	// register shortcodes
	public function wpcr_register_shortcodes($atts) {
		// average rating
		add_shortcode( 'wppr_avg_rating', array( $this, 'wpcr_avg_rating' ) );
		// average rating by post ID
		add_shortcode( 'wppr_avg_rating_post_id', array( $this, 'wpcr_avg_rating_post_id' ) );
		
	}
	/* AVERAGE RATING SHORTCODE */
	public function wpcr_avg_rating($atts ) {
		$a = shortcode_atts( array(
			'title' => 'Rating',
			), $atts );
			
		global $post;
		
		$args = array('post_id' => $post->ID);
	
	$comments = get_comments($args);
	//var_dump($comments);
	
	$sum = 0;
	$count=0;
	
foreach($comments as $comment) :
	
	 $approvedComment = $comment->comment_approved; 
	
	 if($approvedComment > 0){  
	 $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
	 }
	 if($rates){
		 $sum = $sum + (int)$rates;
		 $count++;
 	}
    
	endforeach;
		if($count != 0){ 
			$result=   $sum/$count;
		}else {
			$result= 0;
		}
	
	$chkresults = get_option('wpcr_settings');
	$check_val = isset($chkresults['checkbox2']) ? $chkresults['checkbox2'] : false;
	$tooltip_inline = isset($chkresults['tooltip_inline']) ? $chkresults['tooltip_inline'] : false;
	$avgrating_text = isset($chkresults['wpcravg_text']) ? $chkresults['wpcravg_text'] : false;
	
	
		if($avgrating_text == ''){
			$avg_text = __( 'Average', 'wp-post-comment-rating' );
		}else{
			$avg_text = $avgrating_text;
		}
			
			$avgText = __('average', 'wp-post-comment-rating');
			$outOf   = __('out of 5. Total', 'wp-post-comment-rating');
				
			
			if($count > 0){ 
				if($tooltip_inline == 1){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_tooltip" title="'.$avgText.': '.round($result,2).' '.$outOf.': '.$count.'"><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a></div>';
				}
				if($tooltip_inline == 0){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_inline" title=""><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a><span class="avg-inline">('.$avgText.': <strong> '.round($result, 2).'</strong> '.$outOf.': '.$count.')</span></div>';
				}
					
				 
                return $output;
			}else{
				return '';
			}
	}

	/* AVERAGE RATING SHORTCODE BY POST ID */
	public function wpcr_avg_rating_post_id($atts ) {
		$info = shortcode_atts( array(
			'id' => false,
			), $atts );
			
		global $post;
	
	$postID = $info['id'];
	$args = array('post_id' => $postID);
	
	$comments = get_comments($args);
	//var_dump($comments);
	
	$sum = 0;
	$count=0;
	
foreach($comments as $comment) :
	
	 $approvedComment = $comment->comment_approved; 
	
	 if($approvedComment > 0){  
	 $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
	 }
	 if($rates){
		 $sum = $sum + (int)$rates;
		 $count++;
 	}
    
	endforeach;
		if($count != 0){ 
			$result=   $sum/$count;
		}else {
			$result= 0;
		}
	
	$chkresults = get_option('wpcr_settings');
	$check_val = isset($chkresults['checkbox2']) ? $chkresults['checkbox2'] : false;
	$tooltip_inline = isset($chkresults['tooltip_inline']) ? $chkresults['tooltip_inline'] : false;
	$avgrating_text = isset($chkresults['wpcravg_text']) ? $chkresults['wpcravg_text'] : false;
	
		if($avgrating_text == ''){
			$avg_text = __( 'Average', 'wp-post-comment-rating' );
		}else{
			$avg_text = $avgrating_text;
		}
			
			$avgText = __('average', 'wp-post-comment-rating');
			$outOf   = __('out of 5. Total', 'wp-post-comment-rating');
			
				$feat_img = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'thumbnail_size' );
				$img_url = $feat_img[0];
				
				$p_title = get_the_title($postID);
				$topr_desc = get_the_content($postID);
				$words = 15;
				$more = ' […]';
				$excerpt = wp_trim_words( $topr_desc, $words, $more );			
			
			if($count > 0){ 
				if($tooltip_inline == 1){
					$output = '<div class="main-o"><div class="p-img"><img src="'.$img_url.'"/></div><div class="wpcr_aggregate"><a class="wpcr_tooltip" title="'.$avgText.': '.round($result,2).' '.$outOf.': '.$count.'"><span class="wpcr_stars" title="">'.$avg_text.':</span><span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a></div><p style="clear: left;">'.$excerpt.'</p></div>';
				}
				if($tooltip_inline == 0){
					$output = '<div class="main-o"><div class="p-img"><img src="'.$img_url.'"/><h5>平均スコア</h5><div class="wpcr_aggregate"><a class="wpcr_inline" title=""><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a></div><p style="clear: left;">'.$excerpt.'</p></div>';
				}
					
				 
                return $output;
			}else{
				return '';
			}
	}


	// return RATING FIELD DATA
	public function wpcr_form_rate_field(){
		return WP_Post_Comment_Rating_Common::wpcr_comment_form_rate_field( );
	}
	// SAVE META DATA VALUE
	public function wpcr_meta_data_save($comment_id){
		return WP_Post_Comment_Rating_Common::wpcr_save_comment_meta_data( $comment_id );
	}
	// VERIFY META DATA VALUE
	public function wpcr_meta_data_verify($commentdata){
		return WP_Post_Comment_Rating_Common::wpcr_verify_comment_meta_data( $commentdata );
	}
	// RETURN AVG WITH THE_TAGS FUNCTION
	public function wpcr_tag_aggr_val($tag_list, $before, $sep){
		return WP_Post_Comment_Rating_Common::wpcr_tag_aggr($tag_list, $before, $sep );
	}
	// Show rating stars with visitors comment
	public function wpcr_comment_text_vote_val($text,$comment){
		return WP_Post_Comment_Rating_Common::wpcr_comment_text_vote($text,$comment);
	}
	// Show NAVIGATION LINKS
	public function wpcr_show_nav_links_val($html){
		return WP_Post_Comment_Rating_Common::wpcr_show_nav_links($html);
	}
	// ADD META TAGS FOR SOCIAL SHARE
	public function wpcr_social_tags(){
		return WP_Post_Comment_Rating_Common::wpcr_meta_tags_social();
	}
	// RETURN STRUCTURED DATA
	public function wpcr_rich_snippets_val($content){
		return WP_Post_Comment_Rating_Common::wpcr_rich_snippets($content);
	}
	// RETURN STYLE VALUES FOR STARS
	public function wpcr_style_options_val(){
		return WP_Post_Comment_Rating_Settings::wpcr_style_options();
	}
	
	
}
