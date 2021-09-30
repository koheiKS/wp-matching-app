<?php
?>
<div class="wrap">
	<h3>新規バナー登録</h3>
	<form action="" method="post" id="banner-form">
		<?php echo $atts['nonce_field']; ?>
		<p>
			<label for="banner-text">バナーテキスト:</label>
			<input type="text" name="banner-text" />
		</p>
		<p>
			<label for="banner-url">バナーURL:</label>
			<input type="text" name="banner-url" />
		</p>
		<p>
			<input type="hidden" name="banner-cat-id" value=<?php echo $atts['id']; ?> />
		</p>
		<p>
			<input type='submit' value='保存' class='button button-primary button-large'>
		</p>
	</form>
	<h3>既存バナー編集</h3>
	<table class="wp-list-table widefat fixed striped table-view-list">
		<thead>
			<tr>
				<td class="manage-column column-cb check-column"><input type="checkbox"></td>
				<th>ID</th>
				<th>バナーテキスト</th>
				<th>リンクURL</th>
			</tr>
		</thead>
		<tbody>
<?php
	$id = $atts['id'];
	foreach ($atts['banners'] as $banner) {
		$ban_id = $banner->get_id();
		$text   = $banner->get_text();
		$url    = $banner->get_url();
?>
			<tr>
				<th scope="row" class="check-column">
					<input type="checkbox">
				</th>
				<td>
					<?php echo $ban_id; ?>
					<div class="row-actions">
						<span class="edit"><a href="">編集</a> | </span>
						<span class="trash"><a href="<?php echo home_url("/wp-admin/admin.php?page=custom-banner&action=edit&id=$id&ban-action=delete&ban-id=$ban_id"); ?>" class="submitdelete">削除</a></span>
					</div>
				</td>
				<td>
					<?php echo $text; ?>
				</td>
				<td>
					<?php echo $url; ?>
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>

