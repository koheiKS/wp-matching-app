<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php $current_user_id = wp_get_current_user()->ID; ?>

<?php if (isset($_GET['booking_id']) && isset($_GET['supplier_id']) && ($_GET['supplier_id'] == $current_user_id)) : ?>
<main role="main">
        <h1 class="text-center">予約詳細</h1>
        <div class="container mt-2">
                <?php echo do_shortcode("[sc-show-supplier-booking booking_id=" .$booking_id. "]") ?>
        </div>
</main>
<?php endif; ?>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
