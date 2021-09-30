<div class="service card mb-2 shadow mx-0" style="width:100%;">
	<a href="<?php the_permalink(); ?>" style="text-decoration: none;">
		<div class="card-header p-0">
			<figure class="m-0 card-img-frame">
				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail('medium', array('class' => 'card-img-style')); ?>
				<?php else: ?>
					<?php
					$pic = get_field('pic');
					$imgurl = wp_get_attachment_image_src($pic, 'medium_large')
					?>
					<img src="<?php echo $imgurl[0]; ?>" class="card-img-style" alt="" style="height:300px; width:100%">
				<?php endif; ?>
			</figure>
		</div>
		<div class="card-body">
			<h3 class="service_title">
				<?php the_title(); ?>
			</h3>
			<p class="service_price">
				<span><i class="fas fa-tag"></i> 価格 </span><?php the_field('price'); ?>
			</p>
			<p class="service_desc">
				<?php the_excerpt(); ?>
			</p>
			<p>
                                <?php echo do_shortcode('[wppr_avg_rating_post_id id=' .get_the_ID(). ']'); ?>
                        </p>
		</div>
	</a>
</div>
