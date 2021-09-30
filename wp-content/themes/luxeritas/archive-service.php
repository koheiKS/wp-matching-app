<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

global $luxe;
get_header();
?>
<div id="section"<?php echo $luxe['content_discrete'] === 'indiscrete' ? ' class="grid"' : ''; ?>>
<?php
if( isset( $luxe['grid_type'] ) && isset( $luxe['list_view'] ) && $luxe['list_view'] !== 'content' ) {
        get_template_part( 'loop-grid' );
}
else { ?>
<div class="card">
       <ul class="mx-5 mb-5 nav border-bottom">
		<?php
		$taxonomy_head = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : 'サービス一覧';
		$terms = array(
			'サービス一覧',
			'Web-IT',
			'DIY',
			'ペット',
			'裁縫',
			'ガーデニング',
			'美容',
			'その他'
		);
		$count = 0;
		foreach ( $terms as $term ) {
			$term_sm = mb_strtolower($term);
                        echo "<li class='nav-item'><a href='http://source.oysterworld.jp/matching-app/?post_type=service&taxonomy={$term_sm}' class='nav-link'>" .$term. "</a></li>";
                }
                ?>
	</ul>
        <div>
                <div class="sec_header">
			<h1 class="service-subtitle mx-5 my-3"><?php echo mb_strtoupper($taxonomy_head) ?></h1>
                        <div class="row d-flex text-left">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
							$taxonomy = get_field('taxonomy'); 
						?>
						<?php if ($taxonomy_head == $taxonomy || $taxonomy_head == 'サービス一覧') : ?>
                                                	<div class="col-md-6 d-flex">
                                                        	<?php get_template_part('loop', 'service'); ?>
							</div>
							<?php $count++; ?>
						<?php endif; ?>
                                        <?php endwhile; ?>
				<?php endif; ?>
				<?php if ($count == 0) : ?>
					<div class="mx-auto">
						<h2>カテゴリに当てはまるサービスがありませんでした。</h2>
						<?php $picurl = wp_get_attachment_image_src(526, 'large'); ?>
						<img src="<?php echo $picurl[0]; ?>" class="card-img-top" alt="" style="height:300px; width:300px;">
					</div>
				<?php endif; ?>
                        </div>
                </div>
	</div>
</div>
<?php
}
?>
</div><!--/#section-->
</main>
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
