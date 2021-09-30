<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php $current_user_id = wp_get_current_user()->ID; ?>

<main role="main">
	<h1 class="text-center">スケジュール</h1>
        <div class="container mt-2">
                <?php echo do_shortcode("[sc-show-supplier-schedule user_id=" .$current_user_id. "]") ?>
        </div>
</main>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
