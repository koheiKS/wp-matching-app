<?php
?>
<div class="modal fade" id="booking-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">予約フォーム</h5>
			</div>
			<form action="" method="post" id="sc_new_booking_form">
				<?php echo $atts["nonce_field"]; ?>
				<div class="modal-body">
					<div>
						<input id="booing_customer_id" type="hidden" name="customer_id" value="<?php echo $atts["customer_id"];?>" />
						<input id="booking_service_id" type="hidden" name="service_id" value="<?php echo $atts["service_id"];?>" />
					</div>
				<div>
					<label for="booking_date" class="form-label">予約日</label>
					<input id="booking_date" type="date" name="booking_date" readonly />
				</div>
				<div>
					<label for="booking_time_start" class="form-label">予約時刻</label>
					<select class="time_select_box" id="booking_time_start" name="booking_time_start" onchange="onChange()">
						<option value="">時間を選択</option>
					</select>
				</div>
				<div>
					<label for="booking_time_end">終了時刻</label>
					<input id="booking_time_end" type="time" name="booking_time_end" readonly />
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-large" data-dismiss="modal">閉じる</button>
					<button type="submit" class="btn btn-primary btn-large">予約する</button>
				</div>
			</form>
		</div>
	</div>
</div>
