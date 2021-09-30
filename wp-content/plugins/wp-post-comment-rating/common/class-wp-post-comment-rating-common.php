<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/shoaib88/
 * @since      2.4
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/common
 */


class WP_Post_Comment_Rating_Common {

	protected $loader;

	protected $plugin_name;

	protected $version;

	
	public function __construct() {
		if ( defined( 'WP_Post_Comment_Rating_VERSION' ) ) {
			$this->version = WP_Post_Comment_Rating_VERSION;
		} else {
			$this->version = '2.4';
		}
		$this->plugin_name = 'wp-post-comment-rating';

		}

	public static function wpcr_comment_form_rate_field() {
	    
		$results = get_option('wpcr_settings');
		$rt_enable = isset($results['checkbox1']) ? $results['checkbox1'] : false;
		$stars_label = isset($results['rtlabel']) ? $results['rtlabel'] : false;
		$strt_req = isset($results['rt_req']) ? $results['rt_req'] : false;
			
		if($stars_label !== ''){
			$st_label = $stars_label;
		}else{
			$st_label = __('Please rate', 'wp-post-comment-rating');
		}
		
		$star1_title = __('Very bad', 'wp-post-comment-rating');
		$star2_title = __('Kinda bad', 'wp-post-comment-rating');
		$star3_title = __('Meh', 'wp-post-comment-rating');
		$star4_title = __('Pretty good', 'wp-post-comment-rating');
		$star5_title = __('Rocks!', 'wp-post-comment-rating');
		
		if($rt_enable == 'yes'){
			if($strt_req == 'yes'){
				$reqSy = '*';
			}else{
				$reqSy = '';
			}
				if(!isset($_GET['replytocom'])){
			echo '<fieldset class="wppcr_rating">
			<legend>'.$st_label.'<span class="required">'.$reqSy.'</span></legend>
			<input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="'.$star5_title.'">5 stars</label>
			<input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="'.$star4_title.'">4 stars</label>
			<input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="'.$star3_title.'">3 stars</label>
			<input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="'.$star2_title.'">2 stars</label>
			<input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="'.$star1_title.'">1 star</label>
			</fieldset>';
				}
		}
	}
	
	public function wpcr_save_comment_meta_data( $comment_id ) {
		$rating =  (empty($_POST['rating'])) ? FALSE : $_POST['rating'];
		add_comment_meta( $comment_id, 'rating', $rating );
	}
	
	/* VALIDATION */
	public function wpcr_verify_comment_meta_data( $commentdata ) {
		
			$get_res = get_option('wpcr_settings');
			$strt_req = isset($get_res['rt_req']) ? $get_res['rt_req'] : false;
			
		if($strt_req == 'yes'){	
		if ( ! isset( $_POST['rating'] )|| empty( $_POST['rating'] ) )
			if($_POST['comment_parent'] == 0)
				if ( 'product' != get_post_type() ) 			
			wp_die( __( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with rating.', 'wp-post-comment-rating' ) );
		}	
		return $commentdata;
	}

	/**
	* Add average rating with post meta tags 
	**/

	public static function wpcr_tag_aggr($tag_list, $before, $sep ) {
		
		global $post;
		$args = array('post_id' => $post->ID);
		
		$comments = get_comments($args);
		$rates = '';	
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
				
			
			$avgText   = __('average', 'wp-post-comment-rating');
			$outOf     = __('out of 5. Total', 'wp-post-comment-rating');
			$output = "";
						
			if($check_val == 'yes'){
				if($count > 0){ 
					if($tooltip_inline == 1){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_tooltip" title="'.$avgText.': '.round($result,2).' '.$outOf.': '.$count.'"><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a></div>';
					}
					if($tooltip_inline == 0){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_inline" title=""><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" data-wpcravg="'.round($result,2).'"></span></a><span class="avg-inline">('.$avgText.': <strong> '.round($result, 2).'</strong> '.$outOf.': '.$count.')</span></div>';
					}
										
				} 
                return $tag_list.$output;
			}else{
				return $tag_list;
			}
	}
	
	/* Show rating stars with visitors comment */
	
	public static function wpcr_comment_text_vote($text,$comment){ 
		
		$results = get_option('wpcr_settings');
		$check1 = isset($results['checkbox1']) ? $results['checkbox1'] : false;
		$star_pos = isset($results['cmstr_pos']) ? $results['cmstr_pos'] : false;
		
			
		if($rateres=get_comment_meta($comment->comment_ID,'rating',true))
		{
			
			if($check1 == 'yes' ){
				$countresl = '('.$rateres.'/5)';
				
					$totlrate='<div class="cmstr-out"><span class="wpcr_author_stars" data-rating="'.$rateres.'" ></span><span class="tval">'.$countresl.'</span></div>';
				
				if($star_pos == 1){
					$result = $totlrate.$text;
				}elseif($star_pos == 0){
					$result = $text.$totlrate;
				}else{
					$result = $totlrate.$text;
				}
				
				$text=$result;
			}else{
				 $text=$text;
			}
			
		}
		return $text;
	}

	/* Enable next/prev post links */

	public static function wpcr_show_nav_links($html){
		//ob_start();
		global $post;
		if(is_single()){
			
			$wpcr_options = get_option('wpcr_settings');
			$navval = isset($wpcr_options['shownav']) ? $wpcr_options['shownav'] : false;
			$wpcr_socialshare = isset($wpcr_options['wpcr_social']) ? $wpcr_options['wpcr_social'] : false;	
		
			// Get current page URL 
			$wpcr_URL = get_permalink();
			
			// Get current page title
			$wpcr_Title = str_replace( ' ', '%20', get_the_title());
			
			// Get Post Thumbnail for pinterest
			$wpcr_Thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			
			
			// Construct sharing URL without using any script
			$twitterURL = 'https://twitter.com/intent/tweet?text='.$wpcr_Title.'&amp;url='.$wpcr_URL.'';
			$facebookURL = 'https://www.facebook.com/sharer.php?s=100&amp;p[url]='.$wpcr_URL.'&p[title]='.$wpcr_Title.'&amp;p[images][0]='.$wpcr_Thumbnail[0].'';
			$googleURL = 'https://plus.google.com/share?url='.$wpcr_URL;
		
			if($navval == 1){
				$html .= '<div class="wpcr_floating_links"><ul>';
				
				if($link = get_previous_post_link('%link','<i class="fa-fa-long-arrow-left"></i>' )) {
					$html .= '<li class="prev_link">'.$link.'</li>';
					}else{
					$html .= '<li class="no_link"><i class="fa-fa-long-arrow-left"></i></li>';
				}
				if($nextlink = get_next_post_link('%link','<i class="fa-fa-long-arrow-right"></i>' )) {
					$html .= '<li class="next_link">'.$nextlink.'</li>';
					}else{
					$html .= '<li class="no_link"><i class="fa-fa-long-arrow-right"></i></li>';
				}	
				if($wpcr_socialshare == 1){			
					$html .= '<li class="wpcr_social"><a href="'. $facebookURL .'" target="_blank"><i class="fa-fa-facebook"></i></a></li>';			 
					$html .= '<li class="wpcr_social"><a href="'. $twitterURL .'" target="_blank"><i class="fa-fa-twitter"></i></a></li>';			 
					$html .= '<li class="wpcr_social"><a href="'. $googleURL .'" target="_blank"><i class="fa-fa-google-plus"></i></a></li>';			 
				}
				$html .= '</ul></div>';
			}
		}
		return $html;
	}

	public static function wpcr_meta_tags_social(){
			//ob_start();
			global $post;
		
			$results = get_option('wpcr_settings');
			$wpcr_socialsharee = isset($results['wpcr_social']) ? $results['wpcr_social'] : false;		
		
			// Get current page URL 
			$wpcr_URL = get_permalink();
			
			// Get current page title
			$wpcr_Title = str_replace( ' ', '%20', get_the_title());
			
			
			// Get Post Thumbnail for pinterest
			$wpcr_Thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			
			$post_id = get_queried_object_id();
			$post_obj = get_post( $post_id );
			$content = wp_strip_all_tags($post_obj->post_content);
			//var_dump($content);

				if($wpcr_socialsharee == 1){		
					
					$html = '<meta itemprop="name" content="'.$wpcr_Title.'">';
					$html .= '<meta itemprop="description" content="'.$content.'">';
					$html .= '<meta itemprop="image" content="'.$wpcr_Thumbnail[0].'">';
					
					$html .= '<meta name="twitter:card" content="summary">';
					$html .= '<meta name="twitter:title" content="'.$wpcr_Title.'">';
					$html .= '<meta name="twitter:description" content="'.$content.'">';
					$html .= '<meta name="twitter:image" content="'.$wpcr_Thumbnail[0].'">';
					
					$html .= '<meta property="og:title" content="'.$wpcr_Title.'" />';
					$html .= '<meta property="og:type" content="article" />';
					$html .= '<meta property="og:url" content="'.$wpcr_URL.'" />';
					$html .= '<meta property="og:image" content="'.$wpcr_Thumbnail[0].'" />';
					$html .= '<meta property="og:description" content="'.$content.'" />';
					echo $html;
				}
		}

	/** 
	** Enable google rich snippets
	**/
	public static function wpcr_rich_snippets($content) {
		global $post;
		$args = array('post_id' => $post->ID);
		$comments = get_comments($args);
		$output = '';	
		$sum = 0;
		$count=0;
		$rates = '';
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
			$enable_snippets = isset($chkresults['wpcrrichschema']) ? $chkresults['wpcrrichschema'] : false;
			$schema_type = isset($chkresults['wpcr_structured_data_type']) ? $chkresults['wpcr_structured_data_type'] : false;
						
			$link = get_permalink($post->ID);
			$name = wp_strip_all_tags(get_the_title($post->ID));
			//$author = get_the_author($post->ID);
			$image = get_the_post_thumbnail_url($post->ID);
            $result = round($result, 2);
			if($enable_snippets == 'yes'){
				if($count > 0){ 
					$output = '<script type="application/ld+json">
								{
								"@context": "http://schema.org",
								"@type": "'.$schema_type.'",
								"aggregateRating": {
								"@type": "AggregateRating",
								"bestRating": "5",
								"ratingCount": "'.$count.'",
								"ratingValue": "'.$result.'"
								},
								"image": "'.$image.'",
								"name": "'.$name.'",
								"description": "'.$name.'"
								}
								</script>';
					} 
				return $content.$output;
            }else{
				return $content;
			}
		}

	
}
