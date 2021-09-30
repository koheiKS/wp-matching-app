<?php
?>
<div class="wrap">
	<h3>新規カテゴリ登録</h3>
	<form action="" method="post" id="my-submenu-form">
		<?php echo $atts['nonce_field'] ?>
		<p>
			<label for="category">カテゴリー:</label>
			<input type="text" name="category" />
		</p>
		<p>
			<input type='submit' value='保存' class='button button-primary button-large'>
		</p>
	</form>
	<h3>既存カテゴリ編集</h3>
	<table class="wp-list-table widefat fixed striped table-view-list" id="category-list-table">
		<thead>
			<tr>
				<td class="manage-column column-cb check-column"><input type="checkbox"></td>
				<th>ID</th>
				<th>カテゴリー</th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach ($atts['categories'] as $category) {
		$id = $category->get_id();
		$name = $category->get_name();
?>
			<tr>
				<th scope="row" class="check-column">
					<input type="checkbox">
				</th>
				<td>
					<?php echo $id; ?>
					<div class="row-actions">
						<span class="inline hide-if-no-js">
							<button type="button" class="button-link editinline">名前変更</button> | 
						</span>
						<span class="edit"><a href="<?php echo home_url("/wp-admin/admin.php?page=custom-banner&action=edit&id=$id"); ?>">編集</a> | </span>
						<span class="trash"><a href="<?php echo home_url("/wp-admin/admin.php?page=custom-banner&action=delete&id=$id"); ?>" class="submitdelete">削除</a></span>
					</div>
				</td>
				<td>
					<?php echo $name; ?>
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>

