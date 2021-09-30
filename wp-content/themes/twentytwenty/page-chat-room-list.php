<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php $current_user_id = wp_get_current_user()->ID; ?>
    
<main role="main">
	<div class="container mt-2">
		<?php echo do_shortcode("[display_chat_room_list supplier_id=" .$current_user_id. "]") ?>
	</div>
</main>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
