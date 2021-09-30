<?php
?>
<form action="" method="post" id="sc_new_form">
	<?php echo $atts["nonce_field"]; ?>
	<input type="hidden" name="user_id" value="<?php echo $atts["user_id"]; ?>" />
	<div>
		<label for="start_date" class="form-label">開始日</label>
		<input type="date" name="start_date" />
		<label for="start_time" class="form-label">開始時刻</label>
		<input type="time" name="start_time" step="900" />
	</div>
	<div>
		<label for="end_date" class="form-label">終了日</label>
		<input type="date" name="end_date" />
		<label for="start_time" class="form-label">終了時刻</label>
		<input type="time" name="end_time" step="900" />
	</div>
	<div>
		<label for="status" class="form-label">状態</label>
		<select name="status" class="form-select">
			<option value="0">予約不可</option>
			<option value="1">予約済み</option>
			<option value="2">予約可能</option>
		</select>
	</div>
	<div>
		<input type='submit' value='保存' class='btn btn-primary'>
	</div>
</form>
