<?php

require_once(dirname(__FILE__). '/../entity/Schedule.php');

class ScheduleRep {

	private $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'sc_user_schedule';
	}

	public function save($schedule) {
		global $wpdb;
		$booking = $schedule->get_booking(); 
		$booking_id = isset($booking) ? $schedule->get_booking()->get_id() : 0;
		$wpdb->insert(
			$this->table,
			array(
				'user_id'    => $schedule->get_user()->ID,
				'start_date' => $schedule->get_start_date(),
				'start_time' => $schedule->get_start_time(),
				'end_date'   => $schedule->get_end_date(),
				'end_time'   => $schedule->get_end_time(),
				'status'     => $schedule->get_status(),
				'booking_id' => $booking_id
			)
		);
	}

	public function update($schedule) {
		global $wpdb;
		$booking = $schedule->get_booking();
                $booking_id = isset($booking) ? $schedule->get_booking()->get_id() : 0;
		$wpdb->update(
			$this->table,
			array(
				'user_id'    => $schedule->get_user()->ID,
				'start_date' => $schedule->get_start_date(),
				'start_time' => $schedule->get_start_time(),
				'end_date'   => $schedule->get_end_date(),
				'end_time'   => $schedule->get_end_time(),
				'status'     => $schedule->get_status(),
				'booking_id' => $booking_id
			),
			array('id' => $schedule->get_id())
		);
	}

	public function create_table() {
		global $wpdb;
		$data_db_version= '1.0';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE ".$this->table." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11),
			`start_date` date NOT NULL,
			`start_time` time NOT NULL,
			`end_date` date NOT NULL,
			`end_time` time NOT NULL,
			`status` char(1) NOT NULL,
			`booking_id` bigint(20) NOT NULL,
			PRIMARY KEY  (id),
			FOREIGN KEY  (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
			CHECK (status IN ('0', '1', '2'))
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
