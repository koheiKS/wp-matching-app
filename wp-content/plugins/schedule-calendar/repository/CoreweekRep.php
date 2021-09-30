<?php

class CoreweekRep {

	private $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'sc_user_coreweek';
	}

	public function save($coreweek) {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			array(
				'user_id'               => $coreweek->get_user()->ID,
				'can_on_monday'         => $coreweek->get_can_on_monday(),
				'can_on_tuesday'        => $coreweek->get_can_on_tuesday(),
				'can_on_wednesday'      => $coreweek->get_can_on_wednesday(),
				'can_on_tursday'        => $coreweek->get_can_on_tursday(),
				'can_on_friday'         => $coreweek->get_can_on_friday(),
				'can_on_saturday'       => $coreweek->get_can_on_saturday(),
				'can_on_sunday'         => $coreweek->get_can_on_sunday(),
				'can_on_public_holiday' => $coreweek->get_can_on_public_holiday()
	       		)
		);
	}

	public function update($coreweek) {
		global $wpdb;
		$wpdb->update(
			$this->table,
			array(
				'can_on_monday'         => $coreweek->get_can_on_monday(),
				'can_on_tuesday'        => $coreweek->get_can_on_tuesday(),
				'can_on_wednesday'      => $coreweek->get_can_on_wednesday(),
				'can_on_tursday'        => $coreweek->get_can_on_tursday(),
				'can_on_friday'         => $coreweek->get_can_on_friday(),
				'can_on_saturday'       => $coreweek->get_can_on_saturday(),
				'can_on_sunday'         => $coreweek->get_can_on_sunday(),
				'can_on_public_holiday' => $coreweek->get_can_on_public_holiday
			),
			array('user_id' => $coreweek->get_user()->ID)
		);
	}

	public function create_table() {
		global $wpdb;
		$data_db_version= '1.0';

		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE ".$this->table." (
			`user_id` bigint(20) UNSIGNED NOT NULL,
			`can_on_monday` bool,
			`can_on_tuesday` bool,
			`can_on_wednesday` bool,
			`can_on_tursday` bool,
			`can_on_friday` bool,
			`can_on_saturday` bool,
			`can_on_sunday` bool,
			`can_on_public_holiday` bool,
			PRIMARY KEY (user_id),
			FOREIGN KEY (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE
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
