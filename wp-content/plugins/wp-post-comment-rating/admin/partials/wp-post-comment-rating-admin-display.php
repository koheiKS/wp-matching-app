<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/shoaib88/
 * @since      2.4
 *
 * @package    WP_Post_Comment_Rating
 * @subpackage WP_Post_Comment_Rating/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wpcsr_wrapper">
  <h3><span class="dashicons dashicons-admin-generic"></span><?php echo ( esc_html__('Settings', 'wp-post-comment-rating'));?></h3>
  <div class="left-area">
  <form method="post" action="options.php">
  <?php
  settings_fields('wpcr_options_group');
  $wpcr_options = get_option('wpcr_settings');
  ?>
  <div class="main_options_outer">
  <div class="tab-menu">
	<ul class="wpcr_nav_tabs">
		<li><a href="#" class="tab-a active-a" data-id="tab1"><?php echo ( esc_html__('General', 'wp-post-comment-rating'));?></a></li>
		<li><a href="#" class="tab-a" data-id="tab2"><?php echo ( esc_html__('Stars', 'wp-post-comment-rating'));?></a></li>
		<li><a href="#" class="tab-a" data-id="tab3"><?php echo ( esc_html__('Average Rating', 'wp-post-comment-rating'));?></a></li>
		<li><a href="#" class="tab-a" data-id="tab4"><?php echo ( esc_html__('Floating Links', 'wp-post-comment-rating'));?></a></li>
  </ul>
		</div>
  <div class="tab-content">
    <div id="home" class="tab tab-active" data-id="tab1">
      <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Enable rating', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php $st_rt_enable = isset($wpcr_options['checkbox1']) ? $wpcr_options['checkbox1'] : false;?>
		  <input type="checkbox" name="wpcr_settings[checkbox1]" value="yes" <?php checked('yes', $st_rt_enable); ?> />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Is rating is required?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php $st_rt_req = isset($wpcr_options['rt_req']) ? $wpcr_options['rt_req'] : false;?>
		  <input type="checkbox" name="wpcr_settings[rt_req]" value="yes" <?php checked('yes', $st_rt_req); ?> />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Show average rating', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php $st_avgrt_enable = isset($wpcr_options['checkbox2']) ? $wpcr_options['checkbox2'] : false;?>
		  <input type="checkbox" name="wpcr_settings[checkbox2]" value="yes" <?php checked('yes', $st_avgrt_enable); ?> />
		  <p class="averagerating_info"><?php echo ( esc_html__( 'Add the_tags() function after title if average rating is not shown', 'wp-post-comment-rating' ) ); ?>. </p>
		  <p class="averagerating_info"><?php echo ( esc_html__( 'You can also use shortcode [wppr_avg_rating] to show average rating', 'wp-post-comment-rating' ) ); ?>.</p>
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Rating label', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[rtlabel]" placeholder="Please rate" value="<?php echo esc_attr( $wpcr_options['rtlabel']); ?>"  />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Rating label Color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[txtcolor]" value="<?php echo sanitize_hex_color( $wpcr_options['txtcolor'])?>" data-default-color="#ccc" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Enable Google Rich Snippets?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php $st_wpcrrichschema = isset($wpcr_options['wpcrrichschema']) ? $wpcr_options['wpcrrichschema'] : false;?>
		  <input type="checkbox" name="wpcr_settings[wpcrrichschema]" value="yes" <?php checked('yes', $st_wpcrrichschema); ?> />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Structured data type for rich snippets', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <select id="wpcr_structured_data_type"  name="wpcr_settings[wpcr_structured_data_type]">
			  <option value="none" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'none' ); ?>><?php echo ( esc_html__('None', 'wp-post-comment-rating'));?></option>
			  <option value="Product" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Product' ); ?>><?php echo ( esc_html__('Product', 'wp-post-comment-rating'));?></option>
			  <option value="Book" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Book' ); ?>><?php echo ( esc_html__('Book', 'wp-post-comment-rating'));?></option>
			  <option value="Course" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Course' ); ?>><?php echo ( esc_html__('Course', 'wp-post-comment-rating'));?></option>
			  <option value="TVSeries" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'TVSeries' ); ?>><?php echo ( esc_html__('TVSeries', 'wp-post-comment-rating'));?></option>
			  <option value="CreativeWorkSeason" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'CreativeWorkSeason' ); ?>><?php echo ( esc_html__('CreativeWorkSeason', 'wp-post-comment-rating'));?></option>
			  <option value="CreativeWorkSeries" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'CreativeWorkSeries' ); ?>><?php echo ( esc_html__('CreativeWorkSeries', 'wp-post-comment-rating'));?></option>
			  <option value="Episode" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Episode' ); ?>><?php echo ( esc_html__('Episode', 'wp-post-comment-rating'));?></option>
			  <option value="Game" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Game' ); ?>><?php echo ( esc_html__('Game', 'wp-post-comment-rating'));?></option>
			  <option value="LocalBusiness" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'LocalBusiness' ); ?>><?php echo ( esc_html__('LocalBusiness', 'wp-post-comment-rating'));?></option>
			  <option value="MediaObject" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'MediaObject' ); ?>><?php echo ( esc_html__('MediaObject', 'wp-post-comment-rating'));?></option>
			  <option value="Movie" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Movie' ); ?>><?php echo ( esc_html__('Movie', 'wp-post-comment-rating'));?></option>
			  <option value="MusicPlaylist" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'MusicPlaylist' ); ?>><?php echo ( esc_html__('MusicPlaylist', 'wp-post-comment-rating'));?></option>
			  <option value="MusicRecording" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'MusicRecording' ); ?>><?php echo ( esc_html__('MusicRecording', 'wp-post-comment-rating'));?></option>
			  <option value="Organization" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Organization' ); ?>><?php echo ( esc_html__('Organization', 'wp-post-comment-rating'));?></option>
			  <option value="Recipe" <?php selected( $wpcr_options['wpcr_structured_data_type'], 'Recipe' ); ?>><?php echo ( esc_html__('Recipe', 'wp-post-comment-rating'));?></option>
			</select>
		  </div>
		  </div>
		  
    </div>
	
	
    <div id="menu1" class="tab " data-id="tab2">
		<div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Voted Stars', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <div class="imgrow">
		  <?php $st_rateimage = isset($wpcr_options['rateimage']) ? $wpcr_options['rateimage'] : false;?>
		  <input type="radio" name="wpcr_settings[rateimage]" value="ylrateimg" <?php checked('ylrateimg', $st_rateimage); ?>  />
		  <span class="enable_grateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/star0.png'?>" alt=""/></span>
		  </div>
		  <div class="imgrow">
		  <input type="radio" name="wpcr_settings[rateimage]" value="grateimg" <?php checked('grateimg', $st_rateimage); ?>  />
		  <span class="enable_grateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/star1.png'?>" alt=""/></span>
		  </div>
		  <div class="imgrow">
		  <input type="radio" name="wpcr_settings[rateimage]" value="orateimg" <?php checked('orateimg', $st_rateimage); ?>  />
		  <span class="enable_orateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/star2.png'?>" alt=""/></span>
		  </div>
		  </div>
		 </div>
		 <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Voted stars position with comment', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <div class="nav_position">
		  <?php $st_cmstr_pos = isset($wpcr_options['cmstr_pos']) ? $wpcr_options['cmstr_pos'] : false;?>
		  <input type="radio" name="wpcr_settings[cmstr_pos]" value="1" <?php checked(1, $st_cmstr_pos); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('above', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="nav_position">
		  <input type="radio" name="wpcr_settings[cmstr_pos]" value="0" <?php checked(0, $st_cmstr_pos); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('below', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		</div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Empty stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php if(isset($wpcr_options['stremptycolor']) && !empty($wpcr_options['stremptycolor'])){
		        $emptycolor = $wpcr_options['stremptycolor'];
		  }else{
		        $emptycolor = '#ddd';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[stremptycolor]" value="<?php echo sanitize_hex_color( $emptycolor)?>" data-default-color="#ddd" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Filled stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php if(isset($wpcr_options['strfillcolor']) && !empty($wpcr_options['strfillcolor'])){
		        $filledcolor = $wpcr_options['strfillcolor'];
		  }else{
		        $filledcolor = '#ffd700';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[strfillcolor]" value="<?php echo sanitize_hex_color( $filledcolor)?>" data-default-color="#ffd700" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Selected stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['strselectedcolor']) && !empty($wpcr_options['strselectedcolor'])){
		        $seltedcolor = $wpcr_options['strselectedcolor'];
		  }else{
		        $seltedcolor = '#ea0';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[strselectedcolor]" value="<?php echo sanitize_hex_color( $seltedcolor)?>" data-default-color="#ea0" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Star size', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[starsize]" placeholder="22" value="<?php echo esc_attr( $wpcr_options['starsize']); ?>" style="width: 50px;" /><span><?php echo ( esc_html__('px', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  
		  		  
    </div>
    <div id="menu2" class="tab " data-id="tab3">
      <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Show average rating as', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <div class="aggr_options">
		  <?php $st_tooltip_inline = isset($wpcr_options['tooltip_inline']) ? $wpcr_options['tooltip_inline'] : false;?>
		  <input type="radio" name="wpcr_settings[tooltip_inline]" value="1" <?php checked(1, $st_tooltip_inline); ?>  />
		  <span class="aggr_label"><?php echo ( esc_html__('Tooltip', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="aggr_options">
		  <input type="radio" name="wpcr_settings[tooltip_inline]" value="0" <?php checked(0, $st_tooltip_inline); ?>  />
		  <span class="aggr_label"><?php echo ( esc_html__('Inline', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Average rating text', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[wpcravg_text]" placeholder="Average rating" value="<?php echo esc_attr( $wpcr_options['wpcravg_text']); ?>" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip background color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['tltpbgcolor']) && !empty($wpcr_options['tltpbgcolor'])){
		        $tltbgcolor = $wpcr_options['tltpbgcolor'];
		  }else{
		        $tltbgcolor = 'rgba(0,0,0,.8)';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[tltpbgcolor]" value="<?php echo sanitize_hex_color( $tltbgcolor)?>" data-default-color="rgba(0,0,0,.8)" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip text color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['tiptxtcolor']) && !empty($wpcr_options['tiptxtcolor'])){
		        $tiptxtcolor = $wpcr_options['tiptxtcolor'];
		  }else{
		        $tiptxtcolor = '#fff';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[tiptxtcolor]" value="<?php echo sanitize_hex_color( $tiptxtcolor)?>" data-default-color="#fff" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip text size', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[tiptxtsize]" placeholder="12" value="<?php echo esc_attr( $wpcr_options['tiptxtsize']); ?>" style="width: 50px;" /><span><?php echo ( esc_html__('px', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  
    </div>
	
	<div id="menu3" class="tab " data-id="tab4">
      <div class="wpcr_pagioptions">
		<div class="right-main-sec">
		 <div class="wpcr_pagioptions">
			
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Enable next/prev post links?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="navlinks_options">
		  <?php $st_shownav = isset($wpcr_options['shownav']) ? $wpcr_options['shownav'] : false;?>
		  <input type="checkbox" name="wpcr_settings[shownav]" value="1" <?php checked(1, $st_shownav); ?>  />
		  </div>
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Enable social share links?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="navlinks_options">
		  <?php $st_wpcr_social = isset($wpcr_options['wpcr_social']) ? $wpcr_options['wpcr_social'] : false;?>
		  <input type="checkbox" name="wpcr_settings[wpcr_social]" value="1" <?php checked(1, $st_wpcr_social); ?>  />
		  </div>
		  </div>
		  </div>
		  
		 		  
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Position', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="nav_position">
		  <?php $st_navpos = isset($wpcr_options['navpos']) ? $wpcr_options['navpos'] : false;?>
		  <input type="radio" name="wpcr_settings[navpos]" value="1" <?php checked(1, $st_navpos); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('Left', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="nav_position">
		  <input type="radio" name="wpcr_settings[navpos]" value="0" <?php checked(0, $st_navpos); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('Right', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		</div>
		</div>
    </div>
    
  </div>
 </div> <!-- main options outer div close -->   
 
	
 
  <?php submit_button(); ?>
  </form>
  <div class="donate-message" style="float:right;">
	<?php $rating_img = '<a href="https://wordpress.org/support/plugin/wp-post-comment-rating/reviews/?filter=5" target="_blank">
<img src=" '.plugin_dir_url( dirname( __FILE__ ) ) . 'images/five_stars_rating.png" style="width: 54px;vertical-align: top;"></a>';
 printf( esc_html__( 'Thank you for using WP Post Rating. Please rate %s', 'wp-post-comment-rating' ), $rating_img );?>
  </div>
  </div>
  
</div>