<?php

class CoretimeRep {
	
	private $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'sc_user_coretime';
	}

	public function save($coretime) {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			array(
				'user_id'          => $coretime->get_user()->ID,
				'start_time'       => $coretime->get_start_time(),
				'end_time'         => $coretime->get_end_time(),
				'start_break_time' => $coretime->get_start_break_time(),
				'end_break_time'   => $coretime->get_end_break_time()
			)
		);
	}

	public function update($coretime) {
		global $wpdb;
		$wpdb->update(
			$this->table,
			array(
				'user_id'          => $coretime->get_user()->ID,
				'start_time'       => $coretime->get_start_time(),
				'end_time'         => $coretime->get_end_time(),
				'start_break_time' => $coretime->get_start_break_time(),
				'end_break_time'   => $coretime->get_end_break_time()
			),
			array('user_id' => $coretime->get_user()->ID)
		);
	}
	
	public function create_table() {
		global $wpdb;
		$data_db_version= '1.0';

		$table = $wpdb->prefix . 'sc_user_coretime';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE ".$this->table." (
			`user_id` bigint(20) UNSIGNED NOT NULL,
			`start_time` time NOT NULL,
			`end_time` time NOT NULL,
			`start_break_time` time NOT NULL,
			`end_break_time` time NOT NULL,
			PRIMARY KEY  (user_id),
			FOREIGN KEY  (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
			CHECK (start_time < end_time)
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
