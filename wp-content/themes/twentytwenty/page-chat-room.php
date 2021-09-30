<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php $current_user_id = wp_get_current_user()->ID; ?>

<?php if (isset($_GET['supplier_id']) && isset($_GET['customer_id']) && ($_GET['supplier_id'] == $current_user_id) || $_GET['customer_id'] == $current_user_id)  : ?>
	<?php $supplier_id      = $_GET['supplier_id']; ?>
	<?php $supplier_name    = get_userdata($supplier_id)->user_login; ?>
	<?php $supplier_avatar  = get_avatar($supplier_id); ?>
	<?php $customer_id      = $_GET['customer_id']; ?>
	<?php $customer_name    = get_userdata($customer_id)->user_login; ?>
	<?php $customer_avatar  = get_avatar($customer_id); ?>
	<?php read_wise_chat($supplier_id, $customer_id); ?>
	<main role="main">
		<div class="container mt-2">
			<ul class="list-group mb-2">
				<li class="list-group-item">サービス提供者様：<?php echo $supplier_name; ?></li>
				<li class="list-group-item">お客様　　　　　：<?php echo $customer_name; ?></li>
			</ul>
			<?php echo do_shortcode('[wise-chat channel=chat-room-' . $supplier_id . '-' . $customer_id . ']'); ?>
		</div>
	</main>
<?php endif; ?>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
