<?php get_header(); ?>

<?php get_template_part('template-parts/breadcrumb'); ?>

<style>
#main {
max-width: 1080px; /*任意の最大幅*/
width: 100%; /*スマホ対応 レスポンシブ*/
flex: 0 1 1080px; /*任意の最大幅と同じ値で*/
float:none; /*左寄せを解除*/
margin: 0 auto; /*記事エリアの中央寄せ*/
}
#side{
display: none;/*サイドメニューを非表示に*/
}
</style>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<main class="main">
			<section class="sec">
				<div class="container">
					<div class="article article-service">
						<div class="row">
							<div class="col-12 col-md-7">
								<div class="card shadow">
									<div class="card-header text-white" style="background-color: #BC8F8F;">
										<div class="row">
											<div class="col-3 my-auto">
												<?php
													$author_id = get_the_author_meta('id');
													$author_img = get_avatar($author_id);
												?>
												<div class="row d-flex align-items-center justify-content-center">
													<?php
													echo $author_img;
													?>
												</div>
												<div class="row d-flex align-items-center justify-content-center" style="color:white">
													By: <?php the_author_posts_link(); ?>
												</div>
											</div>
											<div class="col-9 d-flex my-auto">
												<h1 class="ml-0 my-auto">
													<?php echo the_title(); ?>
												</h1>
											</div>
										</div>
									</div>
									<?php
									$pic = get_field('pic');
									$picurl = wp_get_attachment_image_src($pic, 'medium_large');
									?>
									<img src="<?php echo $picurl[0]; ?>" class="card-img-top" alt="">
									<div>
										<ul class="list-group list-group-flush border-bottom">
											<li class="list-group-item mt-0 ml-0">
												<b><i class="fas fa-tag"></i> 価格　　　</b>
												<span><?php the_field('price'); ?></span>
											</li>
											<li class="list-group-item mt-0 ml-0">
												<b><i class="far fa-clock"></i> 所要時間　</b>
												<span><?php the_field('time'); ?>時間</span>
											</li>
											<li class="list-group-item mt-0 ml-0">
												<b><i class="far fa-calendar"></i> 投稿日　　</b>
												<span><?php the_date(); ?></span>
											</li>
											<li class="list-group-item mt-0 ml-0">
												<?php $current_user_id = wp_get_current_user()->ID; ?>
												<?php $author_id = get_the_author_meta('id'); ?>
												<b><i class="far fa-comments"></i> チャットルーム</b>
												<span><a href="https://source.oysterworld.jp/matching-app/?page_id=414&supplier_id=<?php echo $author_id; ?>&customer_id=<?php echo $current_user_id; ?>">ここをクリック</a></span>
											</li>
										</ul>
										<div class="card-body">
											<div class="serice_content">
												<div class="card-text">
													<?php the_field('content'); ?>
												</div>
												<div class="mb-0">
													<?php if (function_exists('wpfp_link')) { wpfp_link(); } ?>
												</div>
												<div class="mt-0">
													<?php echo do_shortcode('[wppr_avg_rating_post_id id=' .get_the_ID(). ']'); ?>
												</div>
											</div>
											<div class="sub_pic">
												<div class="row">
													<div>
														<?php
														$pic = get_field('sub-pic1');
														$picurl = wp_get_attachment_image_src($pic, 'medium_large');
														?>
														<?php if (!empty($pic)): ?>
															<img src="<?php echo $picurl[0]; ?>" width="200" height="200" alt="">
														<?php endif; ?>
													</div>
													<div>
														<?php
														$pic = get_field('sub-pic2');
														$picurl = wp_get_attachment_image_src($pic, 'medium_large');
														?>
														<?php if (!empty($pic)): ?>
															<img src="<?php echo $picurl[0]; ?>" width="200" height="200" alt="">
														<?php endif; ?>
													</div>
													<div>
														<?php
														$pic = get_field('sub-pic3');
														$picurl = wp_get_attachment_image_src($pic, 'medium_large');
														?>
														<?php if (!empty($pic)): ?>
															<img src="<?php echo $picurl[0]; ?>" width="200" height="200" alt="">
														<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="comments-wrapper section-inner">
									<?php
									comments_template();
									?>
								</div><!-- .comments-wrapper -->
							</div>
							<div class="col-12 col-md-5">
								<div class="card mb-2 shadow">
									<div class="card-header text-white" style="background-color: #CD5C5C;">
										<h1 class="text-center"><?php the_author(); ?>へ</br>お問い合わせ</h1>
									</div>
									<div class="card-body">
										<?php
										echo do_shortcode('[contact-form-7 id="278" title="コンタクトフォーム 1"]');
										?>
									</div>
								</div>
								<div class="card mb-2 shadow">
									<div class="card-header text-white" style="background-color: #D8BfD8;">
										<h1 class="text-center"><?php the_author(); ?>の</br>予定カレンダー</h1>
									</div>
									<div class="card-body mx-auto">
										<?php
										$author_id = get_the_author_meta('id');
										?>
										<?php
										echo do_shortcode('[sc-show-schedule user_id=' .$author_id. ']');
										?>
									</div>
								</div>
								<div class="card shadow">
									<div class="card-header text-white" style="background-color: #99CC99;">
										<h1 class="text-center">決済</h1>
									</div>
									<?php
									$price = preg_replace('/[^0-9]/', '', get_field('price'));
									$ID = get_the_ID();
									?>
									<div>
										<div class="card-body">
											<div id="smart-button-container">
												<div style="text-align: center;">
													<div id="paypal-button-container"></div>
												</div>
											</div>
											<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=JPY" data-sdk-integration-source="button-factory"></script>
											<script>
												function initPayPalButton() {
													paypal.Buttons({
														style: {
															shape: 'rect',
															color: 'gold',
															layout: 'vertical',
															label: 'paypal',

														},

														createOrder: function(data, actions) {
															return actions.order.create({
																purchase_units: [{"amount":{"currency_code":"JPY","value":<?php echo $price; ?>}}]
															});
														},

														onApprove: function(data, actions) {
															return actions.order.capture().then(function(orderData) {

																// Full available details
																console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

																// Show a success message within this page, e.g.
																const element = document.getElementById('paypal-button-container');
																element.innerHTML = '';
																element.innerHTML = '<h3>Thank you for your payment!</h3>';

																// Or go to another URL:  actions.redirect('thank_you.html');

															});
														},

														onError: function(err) {
															console.log(err);
														}
													}).render('#paypal-button-container');
												}
												initPayPalButton();
											</script>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
	<?php endwhile; ?>
<?php endif; ?>

<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
