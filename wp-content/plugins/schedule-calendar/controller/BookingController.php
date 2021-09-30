<?php

require_once(dirname(__FILE__). '/../service/BookingService.php');
require_once(dirname(__FILE__). '/../service/ScModelService.php');

class BookingController {

	private $booking_service;
	private $model;

	public function __construct() {
		$this->booking_service = new BookingService();
		$this->model = new ScModelService();
	}

	function sc_show_customer_booking($atts) {
		extract(shortcode_atts(array(
                        'user_id' => 0,
		), $atts));
		$nonce_field = wp_nonce_field(ScheduleCalendar::CANCEL_BOOKING_ACTION, ScheduleCalendar::CANCEL_BOOKING_NAME);
		$html = <<< SCRIPT
<script>
function cancel_booking(booking_id) {
	var is_canceled = window.confirm('キャンセルしても宜しいですか？');
	if(is_canceled) {
		let f       = document.createElement('form');
		f.method    = 'post';
		f.action    = '';
		f.innerHTML = '$nonce_field';
		f.innerHTML += '<input name="booking_id" value=' + booking_id + ' />';
		document.body.append(f);
		f.submit();
	}
}
</script>
SCRIPT;
		$bookings = $this->get_customer_booking($user_id);
		foreach($bookings as $booking) {
			$file = dirname(__FILE__). "/../templates/customer-booking-card.php";
			$atts = array(
				"booking_id"    => $booking['booking_id'],
				"service_title" => $booking['service_title'],
				"service_url"   => $booking['service_url'],
				"service_img"   => $booking['service_img'],
				"chat_room_url" => $this->get_chat_room_url($booking['booking_id']),
				"date"          => $booking['date'],
				"start_time"    => $booking['start_time'],
				"end_time"      => $booking['end_time']
			);
			$this->model->display_template($file, $atts);
		}
	}
}

?>
