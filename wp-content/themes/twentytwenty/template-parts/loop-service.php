<div class="service card mb-2 shadow">
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
					<img src="<?php echo $imgurl[0]; ?>" class="card-img-style" alt="">
				<?php endif; ?>
			</figure>
		</div>
		<div class="card-body">
			<h4 class="service_title">
				<?php the_title(); ?>	
			</h4>
			<p class="service_price">
				<span>価格 </span><?php the_field('price'); ?>
			</p>
			<div class="service_desc">
				<?php the_excerpt(); ?>	
			</div>
		</div>
	</a>
</div>
