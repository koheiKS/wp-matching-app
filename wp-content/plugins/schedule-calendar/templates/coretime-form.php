<?php
?>
<form action="" method="post" id="sc_new_form">
	<?php echo $atts["nonce_field"]; ?>
	<input type="hidden" name="user_id" value="<?php echo $atts["user_id"]; ?>" />
	<div class="input-group mb-2">
		<div class="input-group-prepend">
			<label for="core_time_start" class="input-group-text">コアタイム開始時刻</label>
		</div>
		<select name="core_time_start" class="time_select_box custom-select"></select>
	</div>
	<div class="input-group mb-2">
		<div class="input-group-prepend">
			<label for="core_time_end" class="input-group-text">コアタイム終了時刻</label>
		</div>
		<select name="core_time_end" class="time_select_box custom-select"></select>
	</div>
	<div class="input-group mb-2">
		<div class="input-group-prepend">
			<label for="break_time_start" class="input-group-text">休憩開始時間</label>
		</div>
		<select name="break_time_start" class="time_select_box custom-select"></select>
	</div>
	<div class="input-group mb-2">
		<div class="input-group-prepend">
			<label for="break_time_end" class="input-group-text">休憩終了時間</label>
		</div>
		<select name="break_time_end" class="time_select_box custom-select"></select>
	</div>
	<div>
		<label for="core_week" class="form-label">稼働曜日を選択</label>
		<input type="checkbox" name="core_week[]" value="0" />月曜日
		<input type="checkbox" name="core_week[]" value="1" />火曜日
		<input type="checkbox" name="core_week[]" value="2" />水曜日
		<input type="checkbox" name="core_week[]" value="3" />木曜日
		<input type="checkbox" name="core_week[]" value="4" />金曜日
		<input type="checkbox" name="core_week[]" value="5" />土曜日
		<input type="checkbox" name="core_week[]" value="6" />日曜日
	</div>
	<div>
		<label for="cannot_on_public_holiday" class="form-label">祝日を反映する？</label>
		<input type="radio" name="cannot_on_public_holiday" value="0">いいえ
		<input type="radio" name="cannot_on_public_holiday" value="1" checked>はい
	</div>
	<div>
		<input type='submit' value='保存' class='button button-primary button-large'>
	</div>
</form>
