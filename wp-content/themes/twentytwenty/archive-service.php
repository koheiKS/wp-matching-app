<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<main role="main">
	<ul>
		<?php
		$terms = get_terms('service_category');
		foreach ( $terms as $term ) {
			echo '<li><a href="'.get_term_link($term).'">'.esc_html($term->name).'</a></li>';
		}
		?>
	</ul>
	<div class="container">
		<div class="sec_header">
			<h2 class="service-subtitle">サービス</h2>
			<div class="row justify-content-center">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="col-md-3">
							<?php get_template_part('template-parts/loop', 'service'); ?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</main>

<?php
pagenation(3, 'service');
?>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
