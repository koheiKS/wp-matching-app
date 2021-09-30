<?php

require_once(dirname(__FILE__). '/../entity/Booking.php');

class BookingRep {

	private $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'sc_booking';
	}

	public function save($booking) {
		global $wpdb;
		$user_id     = $booking->get_user()->ID;
		$service_id  = $booking->get_service()->ID;
		$start_date  = $booking->get_start_date();
		$end_date    = $booking->get_end_date();
		$end_time    = $booking->get_end_time();
		$is_canceled = $booking->get_is_canceled();
		$is_accepted = $booking->get_is_accepted();
		$wpdb->insert(
			$this->table,
			array(
				'user_id'     => $user_id,
				'service_id'  => $service_id,
				'start_date'  => $start_date,
				'start_time'  => $start_time,
				'end_date'    => $end_date,
				'end_time'    => $end_time,
				'is_canceled' => $is_canceled,
				'is_accepted' => $is_accepted
			)
		);
		$booking_id = $wpdb->insert_id;
		return new Booking($booking_id, $booking->get_user(), $booking->get_service(), $start_date, $start_time, $end_date, $end_time, $is_canceled, $is_accepted);
	}

	public function update($booking) {
		global $wpdb;
		$wpdb->update(
			$this->table,
			array(
				'user_id'     => $booking->get_user()->ID,
				'service_id'  => $booking->get_service()->ID,
				'start_date'  => $booking->get_start_date(),
				'start_time'  => $booking->get_start_time(),
				'end_date'    => $booking->get_end_date(),
				'end_time'    => $booking->get_end_time(),
				'is_canceled' => $booking->get_is_canceled(),
				'is_accepted' => $booking->get_is_accepted()
			),
			array('id' => $booking->get_id())
                );
	}

	public function create_table() {
		global $wpdb;
		$data_db_version= '1.0';

		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE ".$this->table." (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`user_id` bigint(20) UNSIGNED NOT NULL,
			`service_id` bigint(20) UNSIGNED NOT NULL,
			`start_date` date NOT NULL,
			`start_time` time NOT NULL,
			`end_date` date NOT NULL,
			`end_time` time NOT NULL,
			`is_canceled` bool,
			`is_accepted` bool,
			PRIMARY KEY (id),
			FOREIGN KEY (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
			FOREIGN KEY (service_id) REFERENCES wp_posts(ID) ON DELETE CASCADE
		) ".$charset_collate.";";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'data_db_version', $data_db_version );
	}

	public function drop_table() {
		$wpdb->query("DROP TABLE IF EXISTS ".$this->table."");
	}

}

?>
